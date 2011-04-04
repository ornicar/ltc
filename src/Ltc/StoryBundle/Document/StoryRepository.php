<?php

namespace Ltc\StoryBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;

class StoryRepository extends DocumentRepository
{
    /**
     * Find all tags ordered by creation date desc
     *
     * @return array
     **/
    public function findAll()
    {
        return $this->createQueryBuilder()
            ->sort('createdAt', 'desc')
            ->getQuery()
            ->execute();
    }

    /**
     * Gets the featured story
     *
     * @return Story
     **/
    public function findOneFeatured()
    {
        return $this->createQueryBuilder()
            ->sort('publishedAt', 'desc')
            ->limit(1)
            ->getQuery()
            ->getSingleResult();
    }
}
