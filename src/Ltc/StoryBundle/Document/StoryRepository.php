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
}
