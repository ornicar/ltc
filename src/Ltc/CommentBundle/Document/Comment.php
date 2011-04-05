<?php

namespace Ltc\CommentBundle\Document;

use FOS\CommentBundle\Document\Comment as BaseComment;
use DateTime;

/**
 * @mongodb:Document(
 *   collection="comment"
 * )
 */
class Comment extends BaseComment
{
    /**
     * The author name
     *
     * @mongodb:String
     * @var string
     */
    protected $authorName = 'Anonyme';

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
