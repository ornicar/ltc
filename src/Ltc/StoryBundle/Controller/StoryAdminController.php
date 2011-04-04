<?php

namespace Ltc\StoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ltc\StoryBundle\Document\Story;
use Ltc\StoryBundle\Form\StoryForm;

class StoryAdminController extends Controller
{
    public function indexAction()
    {
        $stories = $this->get('ltc_story.repository.story')->findAll();

        return $this->render('LtcStory:Admin:index.html.twig', array(
            'objects' => $stories
        ));
    }

    public function newAction()
    {
        $this->get('ltc_admin.menu.main')->getChild('Actus')->setIsCurrent(true);
        $story = new Story();

        $form = $this->createForm();
        $form->bind($this->get('request'), $story);

        if ($form->isValid()) {
            $this->get('doctrine.odm.mongodb.document_manager')->persist($story);
            $this->save();

            return new RedirectResponse($this->get('router')->generate('ltc_story_admin_story_list'));
        }

        return $this->render('LtcStory:Admin:new.html.twig', array(
            'story' => $story,
            'form' => $form
        ));
    }

    public function editAction($id)
    {
        $story = $this->get('ltc_story.repository.story')->find($id);
        $this->get('ltc_admin.menu.main')->getChild('Actus')->setIsCurrent(true);
        $form = $this->createForm();
        $form->bind($this->get('request'), $story);

        if ($form->isValid()) {
            $this->save($form);

            return new RedirectResponse($this->get('router')->generate('ltc_story_admin_story_list'));
        }

        return $this->render('LtcStory:Admin:edit.html.twig', array(
            'story' => $story,
            'form' => $form
        ));
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

    protected function createForm()
    {
        $form = StoryForm::create($this->get('form.context'), 'story');

        return $form;
    }
}
