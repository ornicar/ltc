<?php

namespace Ltc\ArticleBundle\Document;

use DateTime;

/**
 * @mongodb:Document(
 *   collection="category",
 *   repositoryClass="Ltc\ArticleBundle\Document\CategoryRepository"
 * )
 * @mongodb:UniqueIndex(keys={"slug"="asc"}, options={"unique"="true", "dropDups"="true"})
 * @mongodb:Index(keys={"position"="asc"})
 */
class Category
{
    /**
     * Unique ID
     *
     * @var string
     * @mongodb:Id()
     */
    protected $id;

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
     * Title
     *
     * @var string
     * @mongodb:Field(type="string")
     * @gedmo:Sluggable
     */
    protected $title;

    /**
     * Unique slug of the category
     *
     * @var string
     * @mongodb:Field(type="string")
     * @gedmo:Slug(unique="true", updatable="true")
     */
    protected $slug;

    /**
     * Second title, generally longer
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $subtitle;

    /**
     * What this category is about
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $summary;

    /**
     * Used to order categories. The lower, the upper.
     *
     * @var int
     * @mongodb:Field(type="int")
     */
    protected $position;

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param  int
     * @return null
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param  string
     * @return null
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
