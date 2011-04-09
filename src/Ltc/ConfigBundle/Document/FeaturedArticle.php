<?php

namespace Ltc\ConfigBundle\Document;

use Ltc\ArticleBundle\Document\Article;

/**
 * @mongodb:Document
 */
class FeaturedArticle
{
    /**
     * Unique ID
     *
     * @var string
     * @mongodb:Id()
     */
    protected $id;

    /**
     * Article
     *
     * @var Article
     * @mongodb:ReferenceOne(targetDocument="Ltc\ArticleBundle\Document\Article")
     */
    protected $article;

    /**
     * Title
     *
     * @var string
     * @mongodb:Field(type="string")
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
