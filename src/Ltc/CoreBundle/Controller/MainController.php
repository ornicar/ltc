<?php

namespace Ltc\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcCoreBundle:Main:index.html.twig', array(
            'photo' => $this->get('ltc_config.manager')->getConfig('photo')->getDocument()
        ));
    }

    public function authorAction()
    {
        return $this->render('LtcCoreBundle:Main:author.html.twig', array(
            'author' => $this->get('ltc_config.manager')->getConfig('author')->getDocument()
        ));
    }

    public function feedAction()
    {
        return $this->render('LtcCoreBundle:Main:feed.xml.twig', array(
            'docs' => $this->get('ltc_core.doc_provider')->getPublishedDocsSortByPublishedAt(100)
        ));
    }

    public function archiveAction()
    {
        return $this->render('LtcCoreBundle:Main:archive.html.twig', array(
            'blogEntries' => $this->get('ltc_blog.repository.blog_entry')->findPublished(),
            'categories' => $this->get('ltc_core.doc_provider')->getPublishedArticlesCategorized()
        ));
    }
}
