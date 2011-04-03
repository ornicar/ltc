<?php

namespace Ltc\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ltc\ArticleBundle\Document\Category;
use Ltc\ArticleBundle\Form\ArticleForm;
use Ltc\ArticleBundle\Document\Article;

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

    public function newAction($categorySlug)
    {
        $category = $this->get('ltc_article.repository.category')->findOneBySlug($categorySlug);
        if (!$category) {
            throw new NotFoundHttpException(sprintf('No category found with slug "%s"', $categorySlug));
        }
        $this->get('ltc_admin.menu.main')->getChild($category->getTitle())->setIsCurrent(true);
        $article = new Article();
        $article->setCategory($category);

        $form = $this->createForm();
        unset($form['category']);
        $form->bind($this->get('request'), $article);

        if ($form->isValid()) {
            $this->get('doctrine.odm.mongodb.document_manager')->persist($article);
            $form['image']->upload($this->get('ltc_image.uploader'));
            $this->save();

            return new RedirectResponse($this->get('router')->generate('ltc_article_admin_category_view', array(
                'slug' => $categorySlug
            )));
        }

        return $this->render('LtcArticle:ArticleAdmin:new.html.twig', array(
            'article' => $article,
            'form' => $form
        ));
    }

    public function editAction($categorySlug, $slug)
    {
        $article = $this->get('ltc_article.provider')->findArticle($categorySlug, $slug);
        $this->get('ltc_admin.menu.main')->getChild($article->getCategory()->getTitle())->setIsCurrent(true);
        $form = $this->createForm();
        $form->bind($this->get('request'), $article);

        if ($form->isValid()) {
            $form['image']->upload($this->get('ltc_image.uploader'));
            $this->save($form);

            return new RedirectResponse($this->get('router')->generate('ltc_article_admin_category_view', array(
                'slug' => $article->getCategory()->getSlug()
            )));
        }

        return $this->render('LtcArticle:ArticleAdmin:edit.html.twig', array(
            'article' => $article,
            'form' => $form
        ));
    }

    protected function save()
    {
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('ltc_tag.denormalizer')->denormalize();
        $this->get('doctrine.odm.mongodb.document_manager')->flush();
        $this->get('session')->setFlash('notice', 'Modifications enregistrees');
    }

    protected function createForm()
    {
        $form = ArticleForm::create($this->get('form.context'), 'article');
        $form->addCategoryChoice($this->get('ltc_article.repository.category'));
        $form->addTags($this->get('ltc_tag.repository.tag'));

        return $form;
    }
}
