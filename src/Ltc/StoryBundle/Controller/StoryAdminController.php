<?php

namespace Ltc\StoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ltc\StoryBundle\Document\Story;
use Ltc\StoryBundle\Form\StoryForm;
use Ltc\StoryBundle\Form\StoryFormType;

class StoryAdminController extends Controller
{
    public function indexAction()
    {
        $stories = $this->get('ltc_story.repository.story')->findAll();

        return $this->render('LtcStoryBundle:Admin:index.html.twig', array(
            'objects' => $stories
        ));
    }

    public function newAction()
    {
        $story = new Story();

        $form = $this->get('form.factory')->create(new StoryFormType(), $story);
        $request = $this->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->get('doctrine.odm.mongodb.document_manager')->persist($story);
                $this->save();

                return new RedirectResponse($this->get('router')->generate('ltc_story_admin_story_list'));
            }
        }

        return $this->render('LtcStoryBundle:Admin:new.html.twig', array('story' => $story, 'form' => $form->createView()));
    }

    public function editAction($id)
    {
        $story = $this->get('ltc_story.repository.story')->find($id);
        if (!$story) throw new NotFoundHttpException();
        $form = $this->get('form.factory')->create(new StoryFormType(), $story);
        $request = $this->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->save();

                return new RedirectResponse($this->get('router')->generate('ltc_story_admin_story_list'));
            }
        }

        return $this->render('LtcStoryBundle:Admin:edit.html.twig', array('story' => $story, 'form' => $form->createView()));
    }

    public function deleteAction($id)
    {
        $story = $this->get('ltc_story.repository.story')->find($id);
        $this->get('doctrine.odm.mongodb.document_manager')->remove($story);
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('session')->setFlash('notice', 'Actu supprimee');

        return new RedirectResponse($this->get('router')->generate('ltc_story_admin_story_list'));
    }

    protected function save()
    {
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('session')->setFlash('notice', 'Modifications enregistrees');
    }
}
