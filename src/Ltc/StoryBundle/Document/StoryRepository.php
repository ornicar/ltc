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
     * Find one featured story
     *
     * @return Story
     **/
    public function findOneFeatured()
    {
        return $this->createQueryBuilder()
            ->sort('isFeatured', 'desc')
            ->getQuery()
            ->getSingleResult();
    }

    public function findOneRandom()
    {
        $ids = $this->createQueryBuilder()
            ->select('id')
            ->hydrate(false)
            ->getQuery()
            ->execute()
            ->toArray();

        $id = array_rand($ids);

        return $this->findOneById($id);
    }

    /**
     * Sets this story as featured, and unset the other ones
     *
     * @return null
     **/
    public function feature(Story $story)
    {
        foreach ($this->findAll() as $other) {
            $other->setIsFeatured(false);
        }
        $story->setIsFeatured(true);
    }
}
