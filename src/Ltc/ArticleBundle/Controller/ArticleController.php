<?php

namespace Ltc\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ltc\ArticleBundle\Document\Category;

class ArticleController extends Controller
{
    public function viewAction($categorySlug, $slug)
    {
        $article = $this->get('ltc_article.provider')->findArticle($categorySlug, $slug);
        if (!$article) {
            throw new NotFoundHttpException();
        }
        if (!$this->get('ltc_doc.security')->canSee($article)) {
            throw new NotFoundHttpException('Insufficients privileges to see unpublished article');
        }
        $related = $this->get('ltc_core.tag_wizard')->findRelatedDocs($article);

        return $this->render('LtcArticleBundle:Article:view.html.twig', array(
            'doc'     => $article,
            'related' => $related
        ));
    }
}
