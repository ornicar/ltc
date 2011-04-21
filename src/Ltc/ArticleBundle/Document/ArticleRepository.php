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
            ->sort('createdAt', 'desc')
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
        return $this->createPublishedSortedQueryBuilder()
            ->field('category.$id')->equals(new MongoId($category->getId()));
    }

    /**
     * Gets the latest published articles in this category
     *
     * @return array
     **/
    public function findLatestByCategory(Category $category, $limit)
    {
        return $this->createPublishedSortedQueryBuilder()
            ->field('category.$id')->equals(new MongoId($category->getId()))
            ->limit($limit)
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

    /**
     * Gets all published article sorted by their category
     *
     * @return array
     **/
    public function findAllPublishedSortByCategory()
    {
        return $this->createPublishedQueryBuilder()
            ->sort('category.$id', 'asc')
            ->getQuery()
            ->execute();
    }
}
