<?php

namespace Ltc\ArticleBundle\Document;

use Ltc\DocBundle\Document\Doc;

/**
 * @mongodb:Document(
 *   collection="article",
 *   repositoryClass="Ltc\ArticleBundle\Document\ArticleRepository"
 * )
 * @mongodb:Index(keys={"category.$id"="asc"})
 * @mongodb:Index(keys={"slug"="asc"})
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
     */
    protected $slug;

    /**
     * Arbitrary publication date in string format
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $publicationDate;

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
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param  string
     * @return null
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
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
