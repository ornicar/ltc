<?php

namespace Ltc\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    public function indexAction()
    {
        $paginator = $this->get('ltc_core.paginator_factory')->paginate(
            $this->get('ltc_blog.repository.blog_entry')->createPublishedSortedQueryBuilder(),
            $this->get('request')->query->get('page', 1)
        );
        $all = $this->get('ltc_blog.repository.blog_entry')->findPublishedTitleAndSlug();

        return $this->render('LtcBlogBundle:Entry:index.html.twig', array(
            'docs' => $paginator,
            'allDocs' => $all
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
        if (!$blogEntry) {
            throw new NotFoundHttpException();
        }
        if (!$this->get('ltc_doc.security')->canSee($blogEntry)) {
            throw new NotFoundHttpException('Insufficients privileges to see unpublished article');
        }
        $related = $this->get('ltc_core.tag_wizard')->findRelatedDocs($blogEntry);

        return $this->render('LtcBlogBundle:Entry:view.html.twig', array(
            'doc'     => $blogEntry,
            'related' => $related
        ));
    }
}
