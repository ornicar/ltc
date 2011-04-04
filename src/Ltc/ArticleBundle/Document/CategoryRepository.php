<?php

namespace Ltc\ArticleBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;

class CategoryRepository extends DocumentRepository
{
    /**
     * Return all categories indexed by their slug
     *
     * @return array
     **/
    public function findAllIndexBySlug()
    {
        $indexed = array();
        foreach ($this->findAll()->toArray() as $category) {
            $indexed[$category->getSlug()] = $category;
        }

        return $indexed;
    }

    /**
     * Return all titles indexed by slug
     *
     * @return array
     **/
    public function getTitlesIndexBySlug()
    {
        $arrays = $this->createQueryBuilder()
            ->select('title', 'slug')
            ->hydrate(false)
            ->getQuery()
            ->execute();

        $indexed = array();
        foreach ($arrays as $categoryArray) {
            $indexed[$categoryArray['slug']] = $categoryArray['title'];
        }

        return $indexed;
    }
}
