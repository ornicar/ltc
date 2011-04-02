<?php

namespace Ltc\UserBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use MongoId;

/**
 * @mongodb:Document(
 *   collection="user",
 *   repositoryClass="Ltc\UserBundle\Document\UserRepository"
 * )
 */
class User extends BaseUser
{
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * Id
     *
     * @var MongoId
     * @mongodb:Id
     */
    protected $id = null;
}
