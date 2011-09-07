<?php

namespace Ltc\CommentBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use FOS\CommentBundle\Document\Thread as BaseThread;

/**
 * @MongoDB\Document(
 *   collection="comment_thread"
 * )
 */
class Thread extends BaseThread
{
}
