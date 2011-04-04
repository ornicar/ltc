<?php

namespace Ltc\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryAdminController extends Controller
{
    public function viewAction($slug)
    {
        $category = $this->get('ltc_article.repository.category')->findOneBySlug($slug);
        if (!$category) {
            throw new NotFoundHttpException(sprintf('No category found with slug "%s"', $slug));
        }

        return $this->forward('LtcArticle:ArticleAdmin:listByCategory', array(
            'category' => $category
        ));
    }
}
