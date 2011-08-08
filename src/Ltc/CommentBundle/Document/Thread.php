<?php

namespace Ltc\CommentBundle\Document;

use FOS\CommentBundle\Document\Thread as BaseThread;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Thread extends BaseThread
{

}
