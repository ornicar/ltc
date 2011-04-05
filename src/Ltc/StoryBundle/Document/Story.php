<?php

namespace Ltc\StoryBundle\Document;

use DateTime;

/**
 * @mongodb:Document(
 *   collection="story",
 *   repositoryClass="Ltc\StoryBundle\Document\StoryRepository"
 * )
 * @mongodb:Index(keys={"createdAt"="desc"})
 * @mongodb:Index(keys={"isFeatured"="desc"})
 */
class Story
{
    /**
     * Unique ID
     *
     * @var string
     * @mongodb:Id()
     */
    protected $id;

    /**
     * Story title. Should be unique.
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $title;

    /**
     * Full resource url
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $url;

    /**
     * Full text of the story
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $body;

    /**
     * Name of the author of this story
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $authorName;

    /**
     * Creation date
     *
     * @var DateTime
     * @mongodb:Field(type="date")
     * @gedmo:Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * Update date
     *
     * @var DateTime
     * @mongodb:Field(type="date")
     * @gedmo:Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * Whether the story is published or not
     *
     * @var bool
     * @mongodb:Field(type="boolean")
     */
    protected $isPublished;

    /**
     * Publication date
     *
     * @var DateTime
     * @mongodb:Field(type="date")
     */
    protected $publishedAt;

    /**
     * Whether the story is featured or not
     *
     * @var bool
     * @mongodb:Field(type="boolean")
     */
    protected $isFeatured = false;

    /**
     * @return bool
     */
    public function getIsFeatured()
    {
        return $this->isFeatured;
    }

    /**
     * @param  bool
     * @return null
     */
    public function setIsFeatured($isFeatured)
    {
        $this->isFeatured = (bool) $isFeatured;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param  string
     * @return null
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

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
}
