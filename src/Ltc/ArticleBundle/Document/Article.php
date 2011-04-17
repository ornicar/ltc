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
     * Tells whether the doc has a manually set publication date in string format
     *
     * @return bool
     */
    public function hasPublicationDate()
    {
        return (bool) $this->getPublicationDate();
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

    public function getCategoryTitle()
    {
        return $this->getCategory()->getTitle();
    }

    /**
     * Gets a unique comment identifier, usable as a slug
     *
     * @return string
     **/
    public function getCommentIdentifier()
    {
        return $this->getCategory()->getSlug().'-'.$this->getSlug();
    }

    public function __toString()
    {
        return $this->getCategory()->getTitle().' - '.$this->getTitle();
    }
}
