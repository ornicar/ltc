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

    public function viewAction($slug)
    {
        $category = $this->get('ltc_article.repository.category')->findOneBySlug($slug);
        if (!$category) {
            throw new NotFoundHttpException(sprintf('No category found with slug "%s"', $slug));
        }

        return $this->forward('LtcArticle:Article:listByCategory', array(
            'category' => $category
        ));
    }
}
