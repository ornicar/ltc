<?php

namespace Ltc\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ltc\ArticleBundle\Document\Article;
use Symfony\Component\HttpFoundation\Response;

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
        $docs = $this->get('ltc_core.doc_provider')->getPublishedDocsSortByPublishedAt(20);
        $stories = $this->get('ltc_story.repository.story')->findRecent(50)->toArray();
        $objects = array_merge($docs, $stories);

        usort($objects, function($a, $b) {
            return $a->getPublishedAt() < $b->getPublishedAt();
        });

        return $this->render('LtcCoreBundle:Main:feed.xml.twig', array(
            'objects' => array_slice($objects, 0, 30)
        ));
    }

    public function archiveAction()
    {
        return $this->render('LtcCoreBundle:Main:archive.html.twig', array(
            'blogEntries' => $this->get('ltc_blog.repository.blog_entry')->findPublished(),
            'categories' => $this->get('ltc_core.doc_provider')->getPublishedArticlesCategorized()
        ));
    }

    public function featuredAction()
    {
        $config = $this->get('ltc_config.manager')->getConfig('featured_article')->getDocument();
        $doc = $config->getChosenDoc();
        if (null === $doc) {
            return new Response("No featured doc");
        } elseif ($doc instanceof Article) {
            $template = 'LtcArticleBundle:Article:featured.html.twig';
        } else {
            $template = 'LtcBlogBundle:Entry:featured.html.twig';
        }

        return $this->render($template, array('doc' => $doc, 'title' => $config->getTitle()));
    }
}
