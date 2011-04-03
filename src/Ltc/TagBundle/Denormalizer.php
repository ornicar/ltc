<?php

namespace Ltc\TagBundle;

use Ltc\ArticleBundle\Document\ArticleRepository;
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
    public function __construct(ArticleRepository $articleRepository, TagRepository $tagRepository, DocumentManager $documentManager)
    {
        $this->articleRepository = $articleRepository;
        $this->tagRepository     = $tagRepository;
        $this->documentManager   = $documentManager;
    }

    /**
     * Generates the doc counts
     *
     * @return null
     **/
    public function denormalize()
    {
        $articles = $this->articleRepository->findPublished();
        $tags = $this->tagRepository->findAll();
        $tagPopularity = array();
        foreach ($articles as $article) {
            foreach ($article->getTagSlugs() as $tagSlug) {
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

}
