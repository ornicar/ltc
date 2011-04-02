<?php

namespace Ltc\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ltc\ArticleBundle\Document\Category;

class ArticleAdminController extends Controller
{
    public function listByCategoryAction(Category $category)
    {
        $articles = $this->get('ltc_article.repository.article')->findByCategory($category);

        return $this->render('LtcArticle:ArticleAdmin:list.html.twig', array(
            'category' => $category,
            'articles' => $articles
        ));
    }
}
