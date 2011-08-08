<?php

namespace Ltc\CommentBundle\Document;

use FOS\CommentBundle\Document\Comment as BaseComment;
use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="comment"
 * )
 */
class Comment extends BaseComment
{
    /**
     * @var string
     * @MongoDB\Id
     */
    protected $id;

    /**
     * The author name
     *
     * @MongoDB\String
     * @var string
     */
    protected $authorName = 'Anonyme';

    /**
     * Thread of this comment
     *
     * @var Thread
     * @MongoDB\ReferenceOne(targetDocument="MyProject\MyBundle\Document\Thread")
     */
    protected $thread;

    /**
     * @return Thread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * @param Thread $thread
     * @return null
     */
    public function setThread(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Get authorName
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set authorName
     * @return string
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
