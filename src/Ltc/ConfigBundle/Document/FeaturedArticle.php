<?php

namespace Ltc\ConfigBundle\Document;

use Ltc\ArticleBundle\Document\Article;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Ltc\BlogBundle\Document\BlogEntry;
use Ltc\DocBundle\Document\Doc;

/**
 * @MongoDB\Document
 */
class FeaturedArticle
{
    /**
     * Unique ID
     *
     * @var string
     * @MongoDB\Id()
     */
    protected $id;

    /**
     * Article
     *
     * @var Article
     * @MongoDB\ReferenceOne(targetDocument="Ltc\ArticleBundle\Document\Article")
     */
    protected $article;

    /**
     * BlogEntry
     *
     * @var BlogEntry
     * @MongoDB\ReferenceOne(targetDocument="Ltc\BlogBundle\Document\BlogEntry")
     */
    protected $blogEntry;

    /**
     * Title
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * Switch between article and blog entry
     *
     * @var string
     * @MongoDB\String
     */
    protected $switch;

    /**
     * Returns the article or the blog entry depending on the switch
     *
     * @return Doc
     */
    public function getChosenDoc()
    {
        if ($this->getSwitch() == 'article') {
            return $this->getArticle();
        }

        return $this->getBlogEntry();
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
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param  Article
     * @return null
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return BlogEntry
     */
    public function getBlogEntry()
    {
        return $this->blogEntry;
    }

    /**
     * @param BlogEntry
     */
    public function setBlogEntry($blogEntry)
    {
        $this->blogEntry = $blogEntry;
    }

    /**
     * @return string
     */
    public function getSwitch()
    {
        return $this->switch;
    }

    /**
     * @param string
     */
    public function setSwitch($switch)
    {
        $this->switch = $switch;
    }
}
