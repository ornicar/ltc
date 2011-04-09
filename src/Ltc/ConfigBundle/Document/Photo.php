<?php

namespace Ltc\ConfigBundle\Document;

use Ltc\ImageBundle\Document\Image;

/**
 * @mongodb:Document
 */
class Photo
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
     * Main image of the article
     *
     * @var Image
     * @mongodb:EmbedOne(targetDocument="Ltc\ImageBundle\Document\Image")
     */
    protected $image;

    /**
     * Url
     *
     * @var string
     * @mongodb:Field(type="string")
     * @assert:NotBlank
     * @assert:MinLength(3)
     * @assert:MaxLength(300)
     */
    protected $url;

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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}
