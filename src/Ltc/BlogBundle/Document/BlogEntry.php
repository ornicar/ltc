<?php

namespace Ltc\BlogBundle\Document;

use Ltc\DocBundle\Document\Doc;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 *   collection="blog_entry",
 *   repositoryClass="Ltc\BlogBundle\Document\BlogEntryRepository"
 * )
 * @MongoDB\UniqueIndex(keys={"slug"="asc"})
 */
class BlogEntry extends Doc
{
    /**
     * Overrides Doc.slug to give it sluggable options
     *
     * @var string
     * @MongoDB\Field(type="string")
     * @gedmo:Slug(unique="true", updatable="true")
     */
    protected $slug;

    /**
     * Overrides Doc.title to give it sluggable options
     *
     * @var string
     * @MongoDB\Field(type="string")
     * @gedmo:Sluggable
     */
    protected $title;

    /**
     * Tells whether the doc has a manually set publication date in string format
     *
     * @return bool
     */
    public function hasPublicationDate()
    {
        return false;
    }

    /**
     * Gets a unique comment identifier, usable as a slug
     *
     * @return string
     **/
    public function getCommentIdentifier()
    {
        return 'table-ronde-'.$this->getSlug();
    }
}
