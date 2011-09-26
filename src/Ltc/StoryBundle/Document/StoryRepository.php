<?php

namespace Ltc\StoryBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;

class StoryRepository extends DocumentRepository
{
    /**
     * Find all tags ordered by creation date desc
     *
     * @return array of Actu
     **/
    public function findAll()
    {
        return $this->createQueryBuilder()
            ->sort('createdAt', 'desc')
            ->getQuery()
            ->execute();
    }

    /**
     * Gets all actus ordered by createdAt desc
     *
     * @return array of Actu
     **/
    public function findAllSortedByCreatedAt()
    {
        return $this->createQueryBuilder()
            ->sort('createdAt', 'desc')
            ->getQuery()
            ->execute();
    }
}
