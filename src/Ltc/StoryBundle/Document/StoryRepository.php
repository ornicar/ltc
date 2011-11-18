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
     * Gets recent actus, but not  the first one
     *
     * @return array of Actu
     **/
    public function findRecentsButFirst($number)
    {
        return $this->createQueryBuilder()
            ->sort('createdAt', 'desc')
            ->limit($number)
            ->skip(1)
            ->getQuery()
            ->execute();
    }
}
