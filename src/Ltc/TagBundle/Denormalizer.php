<?php

namespace Ltc\TagBundle;

use Ltc\ArticleBundle\Document\ArticleRepository;
use Ltc\BlogBundle\Document\BlogEntryRepository;
use Ltc\TagBundle\Document\TagRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Generates the doc count
 */
class Denormalizer
{
    /**
     * Article repository
     *
     * @var ArticleRepository
     */
    protected $articleRepository = null;

    /**
    * Blog entry repository
    *
    * @var BlogEntryRepository
    */
    protected $blogEntryRepository = null;

    /**
     * Tag repository
     *
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * Document manager
     *
     * @var DocumentManager
     */
    protected $documentManager;

    /**
     * Instanciates a new Denormalizer
     *
     * @param ArticleRepository articleRepository
     */
    public function __construct(ArticleRepository $articleRepository, BlogEntryRepository $blogEntryRepository, TagRepository $tagRepository, DocumentManager $documentManager)
    {
        $this->articleRepository   = $articleRepository;
        $this->blogEntryRepository = $blogEntryRepository;
        $this->tagRepository       = $tagRepository;
        $this->documentManager     = $documentManager;
    }

    /**
     * Generates the doc counts
     *
     * @return null
     **/
    public function denormalize()
    {
        $tags = $this->tagRepository->findAll();
        $tagPopularity = array();

        foreach ($this->getDocs() as $doc) {
            foreach ($doc->getTagSlugs() as $tagSlug) {
                if (!isset($tagPopularity[$tagSlug])) {
                    $tagPopularity[$tagSlug] = 1;
                } else {
                    $tagPopularity[$tagSlug] ++;
                }
            }
        }

        foreach ($tags as $tag) {
            if (!isset($tagPopularity[$tag->getSlug()])) {
                $this->documentManager->remove($tag);
            } else {
                $tag->setDocCount($tagPopularity[$tag->getSlug()]);
            }
        }
    }

    public function getDocs()
    {
        return array_merge(
            $this->articleRepository->findAll()->toArray(),
            $this->blogEntryRepository->findAll()->toArray()
        );
    }
}
