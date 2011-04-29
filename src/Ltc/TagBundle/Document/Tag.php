<?php

namespace Ltc\TagBundle\Document;

/**
 * @mongodb:Document(
 *   collection="tag",
 *   repositoryClass="Ltc\TagBundle\Document\TagRepository"
 * )
 * @mongodb:Index(keys={"docCount"="desc"})
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

    /**
     * Number of docs that have this tag.
     * Denormalized value.
     *
     * @var int
     * @mongodb:Field(type="int")
     */
    protected $docCount;

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

    /**
     * @return int
     */
    public function getDocCount()
    {
        return $this->docCount;
    }

    /**
     * @param  int
     * @return null
     */
    public function setDocCount($docCount)
    {
        $this->docCount = $docCount;
    }

	public function __toString()
	{
		return $this->getTitle();
	}
}
