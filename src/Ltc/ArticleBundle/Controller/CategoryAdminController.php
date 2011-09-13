<?php

namespace Ltc\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ltc\ArticleBundle\Document\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CategoryAdminController extends Controller
{
    public function viewAction($slug)
    {
        $category = $this->get('ltc_article.repository.category')->findOneBySlug($slug);
        if (!$category) {
            throw new NotFoundHttpException(sprintf('No category found with slug "%s"', $slug));
        }

        return $this->forward('LtcArticleBundle:ArticleAdmin:listByCategory', array(
            'category' => $category
        ));
    }

    public function sortAction($slug, Request $request)
    {
        $category = $this->get('ltc_article.repository.category')->findOneBySlug($slug);
        if (!$category) {
            throw new NotFoundHttpException(sprintf('No category found with slug "%s"', $slug));
        }
        $articles = $this->get('ltc_article.repository.article')->findByCategory($category)->toArray();
        if ($request->getMethod() == 'POST') {
            $ids = $request->request->get('sort_id');
            foreach ($articles as $article) {
                $position = array_search($article->getId(), $ids);
                $article->setPosition($position);
            }
            $this->get('doctrine.odm.mongodb.document_manager')->flush();
            $this->get('session')->setFlash('notice', 'Modifications enregistrées');

            return new RedirectResponse($this->get('router')->generate('ltc_article_admin_category_sort', array(
                'slug' => $slug
            )));
        }

        return $this->render('LtcArticleBundle:ArticleAdmin:sortByCategory.html.twig', array(
            'category' => $category,
            'articles' => $articles
        ));
    }
}
