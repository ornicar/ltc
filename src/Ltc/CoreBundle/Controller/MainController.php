<?php

namespace Ltc\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcCore:Main:index.html.twig');
    }

    public function featuredAction($numberOfBlogEntries)
    {
        $featuredArticle   = $this->get('ltc_article.repository.article')->findOneFeatured();
        $featuredStory     = $this->get('ltc_story.repository.story')->findOneFeatured();
        $latestBlogEntries = $this->get('ltc_blog.repository.blog_entry')->findLatest($numberOfBlogEntries);

        return $this->render('LtcCore:Main:featured.html.twig', array(
            'featuredArticle'   => $featuredArticle,
            'featuredStory'     => $featuredStory,
            'latestBlogEntries' => $latestBlogEntries
        ));
    }
}
