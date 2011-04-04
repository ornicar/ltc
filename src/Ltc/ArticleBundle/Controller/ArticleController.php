<?php

namespace Ltc\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ltc\ArticleBundle\Document\Category;

class ArticleController extends Controller
{
    public function listByCategoryAction(Category $category)
    {
        $articles = $this->get('ltc_article.repository.article')->findPublishedByCategory($category);

        return $this->render('LtcArticle:Article:listByCategory.html.twig', array(
            'category' => $category,
            'docs'     => $articles
        ));
    }

    public function viewAction($categorySlug, $slug)
    {
        $article = $this->get('ltc_article.provider')->findPublishedArticle($categorySlug, $slug);
        $related = $this->get('ltc_core.tag_wizard')->findRelatedDocs($article);

        return $this->render('LtcArticle:Article:view.html.twig', array(
            'doc'     => $article,
            'related' => $related
        ));
    }
}
