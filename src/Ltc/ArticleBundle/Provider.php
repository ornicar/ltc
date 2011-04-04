<?php

namespace Ltc\ArticleBundle;

use Ltc\ArticleBundle\Document\CategoryRepository;
use Ltc\ArticleBundle\Document\ArticleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zend\Cache\Manager as CacheManager;

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

    protected $cache;

    /**
     * Instanciates a new Provider
     *
     * @param CategoryRepository categoryRepository
     * @param ArticleRepository articleRepository
     */
    public function __construct(CategoryRepository $categoryRepository, ArticleRepository $articleRepository, CacheManager $cacheManager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->articleRepository  = $articleRepository;
        $this->cache              = $cacheManager->getCache('ltc_article.provider');
    }

    /**
     * Gets categories as an associative array slug => title
     *
     * @return array
     */
    public function getCategoriesInfos()
    {
        $cacheName = 'categories_infos';
        $infos = $this->cache->load($cacheName);

        if (!$infos) {
            $infos = $this->categoryRepository->getTitlesIndexBySlug();
            $this->cache->save($infos, $cacheName);
        }

        return $infos;
    }

    public function findPublishedArticle($categorySlug, $articleSlug)
    {
        $article = $this->findArticle($categorySlug, $articleSlug);
        if (!$article->isPublished()) {
            throw new NotFoundHttpException(sprintf('The article "%s" is not published yet', $articleSlug));
        }

        return $article;
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
