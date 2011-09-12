<?php

namespace Ltc\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ltc\ArticleBundle\Document\Category;
use Ltc\ArticleBundle\Form\ArticleForm;
use Ltc\ArticleBundle\Document\Article;
use Ltc\ArticleBundle\Form\ArticleFormType;

class ArticleAdminController extends Controller
{
    public function listByCategoryAction(Category $category)
    {
        $articles = $this->get('ltc_article.repository.article')->findByCategory($category);

        return $this->render('LtcArticleBundle:ArticleAdmin:listByCategory.html.twig', array(
            'category' => $category,
            'objects' => $articles
        ));
    }

    public function newAction($categorySlug)
    {
        $category = $this->get('ltc_article.repository.category')->findOneBySlug($categorySlug);
        if (!$category) {
            throw new NotFoundHttpException(sprintf('No category found with slug "%s"', $categorySlug));
        }
        $article = new Article();
        $article->setCategory($category);
        $form = $this->get('form.factory')->create(new ArticleFormType(false), $article);
        $request = $this->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->get('doctrine.odm.mongodb.document_manager')->persist($article);
                $this->save();

                return new RedirectResponse($this->get('router')->generate('ltc_article_admin_category_view', array('slug' => $categorySlug)));
            }
        }

        return $this->render('LtcArticleBundle:ArticleAdmin:new.html.twig', array('doc' => $article, 'form' => $form->createView()));
    }

    public function editAction($categorySlug, $slug)
    {
        $article = $this->get('ltc_article.provider')->findArticle($categorySlug, $slug);
        if (!$article) throw new NotFoundHttpException();
        $form = $this->get('form.factory')->create(new ArticleFormType(true), $article);
        $request = $this->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->save();
                $categorySlug = $article->getCategory()->getSlug();

                return new RedirectResponse($this->get('router')->generate('ltc_article_admin_article_edit', array(
                    'categorySlug' => $article->getCategory()->getSlug(),
                    'slug' => $article->getSlug()
                )));
            }
        }

        return $this->render('LtcArticleBundle:ArticleAdmin:edit.html.twig', array('doc' => $article, 'form' => $form->createView()));
    }

    public function deleteAction($id)
    {
        $article = $this->get('ltc_article.repository.article')->find($id);
        $this->get('doctrine.odm.mongodb.document_manager')->remove($article);
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('ltc_tag.denormalizer')->denormalize();
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('session')->setFlash('notice', 'Article supprime');

        return new RedirectResponse($this->get('router')->generate('ltc_article_admin_category_view', array(
            'slug' => $article->getCategory()->getSlug()
        )));
    }

    protected function save()
    {
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('ltc_tag.denormalizer')->denormalize();
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('session')->setFlash('notice', 'Modifications enregistrees');
    }
}
