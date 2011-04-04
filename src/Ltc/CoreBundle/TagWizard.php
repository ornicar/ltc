<?php

namespace Ltc\CoreBundle;

use Ltc\TagBundle\Document\Tag;
use Ltc\TagBundle\Document\TagRepository;
use Ltc\ArticleBundle\Document\Article;
use Ltc\ArticleBundle\Document\ArticleRepository;
use Ltc\BlogBundle\Document\BlogEntry;
use Ltc\BlogBundle\Document\BlogEntryRepository;
use Ltc\DocBundle\Document\Doc;

/**
 * Manipulates tags, articles and blog entries
 */
class TagWizard
{
    /**
     * Tag repository
     *
     * @var TagRepository
     */
    protected $tagRepository = null;

    /**
     * Article repository
     *
     * @var ArticleRepository
     */
    protected $articleRepository = null;

    /**
     * BlogEntry repository
     *
     * @var BlogEntryRepository
     */
    protected $blogEntryRepository = null;

    /**
     * Instanciates a new TagWizard
     *
     * @param TagRepository tagRepository
     * @param ArticleRepository articleRepository
     * @param BlogEntryRepository blogEntryRepository
     */
    public function __construct(TagRepository $tagRepository, ArticleRepository $articleRepository, BlogEntryRepository $blogEntryRepository)
    {
        $this->tagRepository       = $tagRepository;
        $this->articleRepository   = $articleRepository;
        $this->blogEntryRepository = $blogEntryRepository;
    }

    /**
     * Find docs bound to a tag
     *
     * @return array
     **/
    public function findDocsBoundToTag(Tag $tag)
    {
        $blogEntries = $this->blogEntryRepository->findPublishedByTag($tag)->toArray();
        $articles    = $this->articleRepository->findPublishedByTag($tag)->toArray();

        $docs = array_merge($blogEntries, $articles);

        usort($docs, function(Doc $a, Doc $b) {
            return $a->getPublishedAt() < $b->getPublishedAt();
        });

        return $docs;
    }

    /**
     * Find docs related to this doc, based on shared tags
     *
     * @return array
     **/
    public function findRelatedDocs(Doc $doc, $limit = 5)
    {
        $blogEntries = $this->blogEntryRepository->findPublishedRelated($doc);
        $articles    = $this->articleRepository->findPublishedRelated($doc);
        $docs = array_merge($blogEntries, $articles);
        $tagSlugs = $doc->getTagSlugs();

        $correlationClosure = function(array $tagSlugs, $doc)
        {
            return count(array_intersect($tagSlugs, $doc->getTagSlugs()));
        };
        $sortCallback = function(Doc $a, Doc $b) use ($tagSlugs, $correlationClosure)
        {
            return $correlationClosure($tagSlugs, $a) < $correlationClosure($tagSlugs, $b);
        };
        usort($docs, $sortCallback);

        return array_slice($docs, 0, $limit);
    }
}
