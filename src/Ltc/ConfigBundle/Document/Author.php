<?php

namespace Ltc\ConfigBundle\Document;

use Ltc\ImageBundle\Document\Image;

/**
 * @mongodb:Document
 */
class Author
{
    /**
     * Unique ID
     *
     * @var string
     * @mongodb:Id()
     */
    protected $id;

    /**
     * Title
     *
     * @var string
     * @mongodb:Field(type="string")
     * @assert:NotBlank
     * @assert:MinLength(3)
     * @assert:MaxLength(300)
     */
    protected $title;

    /**
     * Short summary
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $summary;

    /**
     * Full text of the article
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $body;

    /**
     * Full text of publications
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $publications;

    /**
     * Main image of the article
     *
     * @var Image
     * @mongodb:EmbedOne(targetDocument="Ltc\ImageBundle\Document\Image")
     */
    protected $image;

    /**
     * Sets the title and generates the slug
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * @param  string
     * @return null
     */
    public function setPublications($publications)
    {
        $this->publications = $publications;
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
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param  Image
     * @return null
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Tells whether or not the author has a valid image
     *
     * @return bool
     */
    public function hasImage()
    {
        return $this->getImage() && $this->getImage()->getPath();
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
}
