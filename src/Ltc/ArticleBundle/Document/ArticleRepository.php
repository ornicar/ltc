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
