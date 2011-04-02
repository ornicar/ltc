<?php

namespace Ltc\ArticleBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;

class CategoryRepository extends DocumentRepository
{
    /**
     * Return the category titles and slugs, without hydrating objects
     *
     * @return array
     **/
    public function getTitlesAndSlugs()
    {
        return $this->createQueryBuilder()
            ->select('title', 'slug')
            ->hydrate(false)
            ->getQuery()
            ->execute();
    }

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
}
