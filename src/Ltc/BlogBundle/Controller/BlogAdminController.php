<?php

namespace Ltc\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ltc\BlogBundle\Form\BlogEntryForm;
use Ltc\BlogBundle\Document\BlogEntry;

class BlogAdminController extends Controller
{
    public function indexAction()
    {
        $blogEntries = $this->get('ltc_blog.repository.blog_entry')->findAll();

        return $this->render('LtcBlog:Admin:index.html.twig', array(
            'objects' => $blogEntries
        ));
    }

    public function newAction()
    {
        $this->get('ltc_admin.menu.main')->getChild('Table ronde')->setIsCurrent(true);
        $blogEntry = new BlogEntry();

        $form = $this->createForm();
        $form->bind($this->get('request'), $blogEntry);

        if ($form->isValid()) {
            $this->get('doctrine.odm.mongodb.document_manager')->persist($blogEntry);
            $form['image']->upload($this->get('ltc_image.uploader'));
            $this->save();

            return new RedirectResponse($this->get('router')->generate('ltc_blog_admin_entry_list'));
        }

        return $this->render('LtcBlog:Admin:new.html.twig', array(
            'doc' => $blogEntry,
            'form' => $form
        ));
    }

    public function editAction($slug)
    {
        $blogEntry = $this->get('ltc_blog.repository.blog_entry')->findOneBySlug($slug);
        $this->get('ltc_admin.menu.main')->getChild('Table ronde')->setIsCurrent(true);
        $form = $this->createForm();
        $form->bind($this->get('request'), $blogEntry);

        if ($form->isValid()) {
            $form['image']->upload($this->get('ltc_image.uploader'));
            $this->save($form);

            return new RedirectResponse($this->get('router')->generate('ltc_blog_admin_entry_list'));
        }

        return $this->render('LtcBlog:Admin:edit.html.twig', array(
            'doc' => $blogEntry,
            'form' => $form
        ));
    }

    public function deleteAction($id)
    {
        $entry = $this->get('ltc_blog.repository.blog_entry')->find($id);
        $this->get('doctrine.odm.mongodb.document_manager')->remove($entry);
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('ltc_tag.denormalizer')->denormalize();
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('session')->setFlash('notice', 'Billet supprime');

        return new RedirectResponse($this->get('router')->generate('ltc_blog_admin_entry_list'));
    }

    protected function save()
    {
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('ltc_tag.denormalizer')->denormalize();
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('session')->setFlash('notice', 'Modifications enregistrees');
    }

    protected function createForm()
    {
        $form = BlogEntryForm::create($this->get('form.context'), 'doc');
        $form->addTags($this->get('ltc_tag.repository.tag'));

        return $form;
    }
}
