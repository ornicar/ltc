<?php

namespace Ltc\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    public function indexAction()
    {
        $blogEntries = $this->get('ltc_blog.repository.blog_entry')->findPublished();

        return $this->render('LtcBlogBundle:Entry:index.html.twig', array(
            'docs' => $blogEntries
        ));
    }

    public function smallListAction($numberOfDocs)
    {
        $blogEntries = $this->get('ltc_blog.repository.blog_entry')->findPublished($numberOfDocs);

        return $this->render('LtcBlogBundle:Entry:smallList.html.twig', array(
            'docs' => $blogEntries
        ));
    }

    public function viewAction($slug)
    {
        $blogEntry = $this->get('ltc_blog.repository.blog_entry')->findOneBySlug($slug);
        $related = $this->get('ltc_core.tag_wizard')->findRelatedDocs($blogEntry);

        return $this->render('LtcBlogBundle:Entry:view.html.twig', array(
            'doc'     => $blogEntry,
            'related' => $related
        ));
    }
}
