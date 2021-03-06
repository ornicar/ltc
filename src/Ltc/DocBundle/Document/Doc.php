<?php

namespace Ltc\DocBundle\Document;

use Ltc\ImageBundle\Document\Image;
use DateTime;
use Gedmo\Sluggable\Util\Urlizer;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @MongoDB\MappedSuperclass
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"createdAt"="desc"}),
 *   @MongoDB\Index(keys={"isPublished"="desc"}),
 *   @MongoDB\Index(keys={"tags"="asc"})
 * })
 */
abstract class Doc
{
    /**
     * Unique ID
     *
     * @var string
     * @MongoDB\Id()
     */
    protected $id;

    /**
     * Creation date
     *
     * @var DateTime
     * @MongoDB\Field(type="date")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * Update date
     *
     * @var DateTime
     * @MongoDB\Field(type="date")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * Title
     *
     * @var string
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\MinLength(3)
     * @Assert\MaxLength(300)
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
     * @MongoDB\Field(type="string")
     */
    protected $summary;

    /**
     * Tags
     *
     * @var array
     * @MongoDB\ReferenceMany(targetDocument="Ltc\TagBundle\Document\Tag", sort={"_id"="asc"})
     */
    protected $tags = array();

    /**
     * Name of the author of this article
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $authorName;

    /**
     * Bio of the author of this article
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $authorBio;

    /**
     * Whether the document is published or not
     *
     * @var bool
     * @MongoDB\Field(type="boolean")
     */
    protected $isPublished;

    /**
     * Publication date
     *
     * @var DateTime
     * @MongoDB\Field(type="date")
     */
    protected $publishedAt;

    /**
     * Full text of the article
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $body;

    /**
     * Main image of the article
     *
     * @var Image
     * @MongoDB\EmbedOne(targetDocument="Ltc\ImageBundle\Document\Image")
     */
    protected $image;

    /**
     * Related publications in text format
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $relatedPublications;

    /**
     * Reference
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $reference;

    /**
     * More links and files text block
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $readMore;

    /**
     * Tells whether the doc has a manually set publication date in string format
     *
     * @return bool
     */
    abstract public function hasPublicationDate();

    /**
     * Gets a unique comment identifier, usable as a slug
     *
     * @return string
     **/
    abstract public function getCommentThreadId();

    /**
     * @return string
     */
    public function getReadMore()
    {
        return $this->readMore;
    }

    /**
     * @param  string
     * @return null
     */
    public function setReadMore($readMore)
    {
        $this->readMore = $readMore;
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
        if ($image->getPath()) {
            $this->image = $image;
        }
    }

    /**
     * Tells whether or not the doc has a valid image
     *
     * @return bool
     */
    public function hasImage()
    {
        return null !== $this->getImage();
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
     * Tells whether the doc has an external author or not
     *
     * @return bool
     **/
    public function hasAuthor()
    {
        return (bool) $this->getAuthorName();
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
     * Gets the tags separated by commas
     *
     * @return string
     **/
    public function getTagsAsString()
    {
        return implode(', ', array_map(function($tag) {
            return $tag->getTitle();
        }, $this->getTags()->toArray()));
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get a shorter version of the title, mainly used for slug generation
     *
     * @return string
     */
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
     * @return string
     */
    public function getRelatedPublications()
    {
        return $this->relatedPublications;
    }

    /**
     * @param  string
     * @return null
     */
    public function setRelatedPublications($relatedPublications)
    {
        $this->relatedPublications = $relatedPublications;
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

    public function isDoc()
    {
        return true;
    }
}
