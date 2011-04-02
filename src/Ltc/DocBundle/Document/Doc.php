<?php

namespace Ltc\DocBundle\Document;

use Ltc\ImageBundle\Document\Image;
use Ltc\UserBundle\Document\User;
use DateTime;

/**
 * @mongodb:MappedSuperclass
 * @mongodb:UniqueIndex(keys={"slug"="asc"}, options={"unique"="false"})
 * @mongodb:Indexes({
 *   @mongodb:Index(keys={"createdAt"="desc"}),
 *   @mongodb:Index(keys={"published"="desc"})
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
     * @gedmo:Sluggable
     */
    protected $title;

    /**
     * Url friendly slug based on title
     *
     * @var string
     * @mongodb:Field(type="string")
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
     * @mongodb:Field(type="collection")
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
     * User author of this article
     *
     * @var User
     */
    protected $author;

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
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param  User
     * @return null
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
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
     * @param  array
     * @return null
     */
    public function setTags(array $tags)
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

    /**
     * @param  string
     * @return null
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
}
