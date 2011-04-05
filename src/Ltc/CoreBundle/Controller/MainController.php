<?php

namespace Ltc\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcCore:Main:index.html.twig');
    }

    public function archiveAction()
    {
        $blogEntries = $this->get('ltc_blog.repository.blog_entry')->findPublished();
        $categories = array();
        foreach ($this->get('ltc_article.repository.category')->findAll() as $category) {
            $categories[$category->getSlug()] = array(
                'category' => $category,
                'articles' => $this->get('ltc_article.repository.article')->findPublishedByCategory($category)
            );
        }

        return $this->render('LtcCore:Main:archive.html.twig', array(
            'blogEntries' => $blogEntries,
            'categories' => $categories
        ));
    }
}
