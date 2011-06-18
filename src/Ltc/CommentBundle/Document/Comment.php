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
