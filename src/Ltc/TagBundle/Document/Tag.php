<?php

namespace Ltc\TagBundle\Document;

/**
 * @mongodb:Document(
 *   collection="tag"
 * )
 * @mongodb:UniqueIndex(keys={"slug"="asc"}, options={"unique"="true", "dropDups"="true"})
 */
class Tag
{
    /**
     * Unique ID
     *
     * @var string
     * @mongodb:Id()
     */
    protected $id;

    /**
     * Tag title. Should be unique.
     *
     * @var string
     * @mongodb:Field(type="string")
     * @gedmo:Sluggable
     */
    protected $title;

    /**
     * Tag slug. Must be unique.
     *
     * @var string
     * @mongodb:Field(type="string")
     * @gedmo:Slug(unique="true", updatable="true")
     */
    protected $slug;

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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
