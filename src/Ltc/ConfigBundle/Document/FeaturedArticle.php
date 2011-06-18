<?php

namespace Ltc\ConfigBundle\Document;

use Ltc\ArticleBundle\Document\Article;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

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
     * Title
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $title;

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
}
