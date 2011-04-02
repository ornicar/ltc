<?php

namespace Ltc\BlogBundle\Document;

use Ltc\DocBundle\Document\Doc;

/**
 * @mongodb:Document(
 *   collection="article"
 * )
 */
class BlogEntry extends Doc
{
    /**
     * Overrides Doc.slug to give it sluggable options
     *
     * @var string
     * @mongodb:Field(type="string")
     * @gedmo:Slug(unique="true", updatable="true")
     */
    protected $slug;
}
