<?php

namespace Ltc\StoryBundle\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(
 *   collection="story",
 *   repositoryClass="Ltc\StoryBundle\Document\StoryRepository"
 * )
 * @MongoDB\Index(keys={"createdAt"="desc"})
 * @MongoDB\Index(keys={"publishedAt"="desc"})
 * @MongoDB\UniqueIndex(keys={"slug"="asc"})
 */
class Story
{
    /**
     * Unique ID
     *
     * @var string
     * @MongoDB\Id()
     */
    protected $id;

    /**
     * Story title. Should be unique.
     *
     * @var string
     * @Assert\NotBlank()
     * @Assert\MinLength(3)
     * @Assert\MaxLength(300)
     * @MongoDB\Field(type="string")
     * @Gedmo\Sluggable
     */
    protected $title;

    /**
     * Url friendly slug based on title
     *
     * @var string
     * @MongoDB\Field(type="string")
     * @Gedmo\Slug(unique="true", updatable="true")
     */
    protected $slug;

    /**
     * Short summary
     *
     * @var string
     * @Assert\NotBlank()
     * @Assert\MinLength(8)
     * @MongoDB\Field(type="string")
     */
    protected $summary;

    /**
     * Full text of the story
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $body;

    /**
     * Name of the author of this story
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $authorName;

    /**
     * Creation date
     *
     * @var DateTime
     * @MongoDB\Field(type="date")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * Update date
     *
     * @var DateTime
     * @MongoDB\Field(type="date")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * Whether the story is published or not
     *
     * @var bool
     * @MongoDB\Field(type="boolean")
     */
    protected $isPublished = true;

    /**
     * Publication date
     *
     * @var DateTime
     * @MongoDB\Field(type="date")
     */
    protected $publishedAt;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->isPublished;
    }

    public function getIsPublished()
    {
        return $this->isPublished();
    }

    /**
     * @param  bool
     * @return null
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = (bool) $isPublished;
        if ($isPublished && !$this->getPublishedAt()) {
            $this->setPublishedAt(new DateTime());
        }
    }

    /**
     * @return DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param  DateTime
     * @return null
     */
    public function setPublishedAt(DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  string
     * @return null
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param  string
     * @return null
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param  string
     * @return null
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param  string
     * @return null
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Tells whether the doc has an external author or not
     *
     * @return bool
     **/
    public function hasAuthor()
    {
        return (bool) $this->getAuthorName();
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param  string
     * @return null
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param  DateTime
     * @return null
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param  DateTime
     * @return null
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets a unique comment identifier, usable as a slug
     *
     * @return string
     **/
    public function getCommentThreadId()
    {
        return 'actu-'.$this->getSlug();
    }

    public function __toString()
    {
        return (string) $this->getTitle();
    }
}
