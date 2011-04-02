<?php

namespace Ltc\TagBundle\Document;

/**
 * @mongodb:Document(
 *   collection="tag",
 *   repositoryClass="Ltc\TagBundle\Document\TagRepository"
 * )
 */
class Tag
{
    /**
     * Unique ID
     *
     * @var string
     * @mongodb:Id(strategy="none")
     */
    protected $slug;

    /**
     * Tag title. Should be unique.
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $title;

    public function __construct($title, $slug)
    {
        $this->title = $title;
        $this->slug  = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
}
