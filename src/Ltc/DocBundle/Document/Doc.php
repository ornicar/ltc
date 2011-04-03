<?php

namespace Ltc\DocBundle\Document;

use Ltc\ImageBundle\Document\Image;
use DateTime;
use Gedmo\Sluggable\Util\Urlizer;
use Doctrine\Common\Collections\Collection;

/**
 * @mongodb:MappedSuperclass
 * @mongodb:Indexes({
 *   @mongodb:Index(keys={"createdAt"="desc"}),
 *   @mongodb:Index(keys={"isPublished"="desc"}),
 *   @mongodb:Index(keys={"tags"="asc"})
 * })
 */
abstract class Doc
{
    /**
     * Unique ID
     *
     * @var string
     * @mongodb:Id()
     */
    protected $id;

    /**
     * Creation date
     *
     * @var DateTime
     * @mongodb:Field(type="date")
     * @gedmo:Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * Update date
     *
     * @var DateTime
     * @mongodb:Field(type="date")
     * @gedmo:Timestampable(on="update")
     */
    protected $updatedAt;

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
     * Url friendly slug based on title
     *
     * @var string
     */
    protected $slug;

    /**
     * Short summary
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $summary;

    /**
     * Tags
     *
     * @var array
     * @mongodb:ReferenceMany(targetDocument="Ltc\TagBundle\Document\Tag", sort={"_id"="asc"})
     */
    protected $tags = array();

    /**
     * Packages provided by the doc
     *
     * @var array
     * @mongodb:EmbedMany(targetDocument="Ltc\PackageBundle\Document\Package")
     */
    protected $packages;

    /**
     * Name of the author of this article
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $authorName;

    /**
     * Bio of the author of this article
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $authorBio;

    /**
     * Whether the document is published or not
     *
     * @var bool
     * @mongodb:Field(type="boolean")
     */
    protected $isPublished;

    /**
     * Publication date
     *
     * @var DateTime
     * @mongodb:Field(type="date")
     */
    protected $publishedAt;

    /**
     * Full text of the article
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $body;

    /**
     * Main image of the article
     *
     * @var Image
     */
    protected $image;

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
     * @return bool
     */
    public function isPublished()
    {
        return $this->isPublished;
    }

    public function getIsPublished()
    {
        return $this->isPublished();
    }

    /**
     * @param  bool
     * @return null
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = (bool) $isPublished;
        if ($isPublished && !$this->getPublishedAt()) {
            $this->setPublishedAt(new DateTime());
        }
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
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
     * @return DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param  DateTime
     * @return null
     */
    public function setPublishedAt(DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param  string
     * @return null
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getAuthorBio()
    {
        return $this->authorBio;
    }

    /**
     * @param  string
     * @return null
     */
    public function setAuthorBio($authorBio)
    {
        $this->authorBio = $authorBio;
    }

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
     * @return array
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param  array
     * @return null
     */
    public function setPackages(array $packages)
    {
        $this->packages = $packages;
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param  Collection
     * @return null
     */
    public function setTags(Collection $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getShortTitle()
    {
        $limit = 40;

        $firstPart = substr($this->getTitle(), 0, strpos($this->getTitle(), ':'));

        if (strlen($firstPart) > $limit) {
            return $firstPart;
        }

        return $this->getTitle();
    }

    /**
     * Sets the title and generates the slug
     * @param  string
     * @return null
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug(Urlizer::urlize($this->getShortTitle()));
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param  DateTime
     * @return null
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param  DateTime
     * @return null
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Return the slugs of this doc tags
     *
     * @return array
     **/
    public function getTagSlugs()
    {
        return array_map(function($tag) { return $tag->getSlug(); }, $this->getTags()->toArray());
    }
}
