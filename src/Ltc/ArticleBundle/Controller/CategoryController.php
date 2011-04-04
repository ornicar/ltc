<?php

namespace Ltc\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function overviewAction()
    {
        $categories = $this->get('ltc_article.repository.category')->findAll()->toArray();
        $categories = array();
        foreach ($this->get('ltc_article.repository.category')->findAll()->toArray() as $category) {
            $categories[] = array(
                'category' => $category,
                'articles' => $this->get('ltc_article.repository.article')->findLatestByCategory($category, 4)
            );
        }

        return $this->render('LtcArticle:Category:overview.html.twig', array('categories' => $categories));
    }
}
