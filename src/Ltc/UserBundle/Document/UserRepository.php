<?php

namespace Ltc\UserBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository
{
    /**
     * Return all users indexed by their canonical username
     *
     * @return array
     **/
    public function findAllIndexByUsernameCanonical()
    {
        $users = $this->createQueryBuilder()
            ->getQuery()
            ->execute()
            ->toArray();

        $indexed = array();
        foreach ($users as $user) {
            $indexed[$user->getUsernameCanonical()] = $user;
        }

        return $indexed;
    }
}
