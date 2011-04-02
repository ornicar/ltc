<?php

namespace Ltc\ArticleBundle\Document;

use Ltc\DocBundle\Document\Doc;

/**
 * @mongodb:Document(
 *   collection="article"
 * )
 */
class Article extends Doc
{
    /**
     * Category
     *
     * @var Category
     * @mongodb:ReferenceOne(targetDocument="Ltc\ArticleBundle\Document\Category")
     */
    protected $category;

    /**
     * Overrides Doc.slug to give it sluggable options
     *
     * @var string
     * @mongodb:Field(type="string")
     * @gedmo:Slug(unique="false", updatable="true")
     */
    protected $slug;

    /**
     * Reference
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $reference;

    /**
     * Arbitrary publication date in string format
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $publication;

    /**
     * Full resource url
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $url;

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
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param  string
     * @return null
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }
    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param  string
     * @return null
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }
    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param  Category
     * @return null
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }
}
