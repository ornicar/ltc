<?php

namespace Ltc\ArticleBundle\Document;

use Ltc\DocBundle\Document\DocRepository;
use MongoId;

class ArticleRepository extends DocRepository
{
    /**
     * Return the articles bound to this category
     *
     * @return array
     **/
    public function findByCategory(Category $category)
    {
        return $this->createQueryBuilder()
            ->field('category.$id')->equals(new MongoId($category->getId()))
            ->sort('position', 'asc')
            ->sort('publishedAt', 'desc')
            ->getQuery()
            ->execute();
    }

    /**
     * Return the published articles bound to this category
     *
     * @return array
     **/
    public function findPublishedByCategory(Category $category)
    {
        return $this->createPublishedSortedByCategoryQueryBuilder($category)
            ->getQuery()
            ->execute();
    }

    /**
     * Return a query builder for the published articles bound to this category
     *
     * @return Builder
     **/
    public function createPublishedSortedByCategoryQueryBuilder(Category $category)
    {
        return $this->createPublishedQueryBuilder()
            ->field('category.$id')->equals(new MongoId($category->getId()))
            ->sort('position', 'asc')
            ->sort('publishedAt', 'desc');
    }

    /**
     * Gets the latest published articles in this category
     *
     * @return array
     **/
    public function findLatestByCategory(Category $category, $limit)
    {
        return $this->createPublishedSortedByCategoryQueryBuilder($category)
            ->limit($limit)
            ->getQuery()
            ->execute();
    }

    /**
     * Finds published documents by category
     * and only loads the titles and slugs
     *
     * @return array of partially hydrated document proxies
     */
    public function findPublishedTitleAndSlugByCategory(Category $category)
    {
        return $this->createPublishedSortedByCategoryQueryBuilder($category)
            ->getQuery()
            ->execute();
    }

    /**
     * Find one article
     *
     * @return Article
     **/
    public function findOneByCategoryAndSlug(Category $category, $slug)
    {
        return $this->createQueryBuilder()
            ->field('category.$id')->equals(new MongoId($category->getId()))
            ->field('slug')->equals($slug)
            ->getQuery()
            ->getSingleResult();
    }
}
