<?php

namespace Ltc\ArticleBundle;

use Ltc\ArticleBundle\Document\CategoryRepository;
use Ltc\ArticleBundle\Document\ArticleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Provides articles based on category and article slugs
 */
class Provider
{
    /**
     * Category repository
     *
     * @var CategoryRepository
     */
    protected $categoryRepository = null;

    /**
     * Article repository
     *
     * @var ArticleRepository
     */
    protected $articleRepository = null;

    /**
     * Instanciates a new Provider
     *
     * @param CategoryRepository categoryRepository
     * @param ArticleRepository articleRepository
     */
    public function __construct(CategoryRepository $categoryRepository, ArticleRepository $articleRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->articleRepository = $articleRepository;
    }

    public function findArticle($categorySlug, $articleSlug)
    {
        $category = $this->categoryRepository->findOneBySlug($categorySlug);
        if (!$category) {
            throw new NotFoundHttpException(sprintf('No category found for slug "%s"', $categorySlug));
        }
        $article = $this->articleRepository->findOneByCategoryAndSlug($category, $articleSlug);
        if (!$article) {
            throw new NotFoundHttpException(sprintf('No article found for category "%s" and slug "%s"', $category->getSlug(), $slug));
        }

        return $article;
    }
}
