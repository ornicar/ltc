<?php

namespace Ltc\UserBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
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
     * @var string
     * @MongoDB\Id
     */
    protected $id = null;
}
