<?php

namespace Ltc\CoreBundle\Search;

use FOQ\ElasticaBundle\Transformer\ElasticaToModelTransformerInterface;
use Ltc\BlogBundle\Document\BlogEntryRepository;
use Ltc\ArticleBundle\Document\ArticleRepository;
use Ltc\DocBundle\Document\Doc;

class ElasticaToModelTransformer implements ElasticaToModelTransformerInterface
{
    protected $blogEntryRepository = null;
    protected $articleRepository = null;

    public function __construct(BlogEntryRepository $blogEntryRepository, ArticleRepository $articleRepository)
    {
        $this->blogEntryRepository = $blogEntryRepository;
        $this->articleRepository   = $articleRepository;
    }

    /**
     * Transforms an array of elastica objects into an array of
     * model objects fetched from the doctrine repository
     *
     * @return array
     **/
    public function transform(array $elasticaObjects)
    {
        $idsByType = array('blog' => array(), 'article' => array());
        foreach ($elasticaObjects as $elasticaObject) {
            $idsByType[$elasticaObject->getType()][] = $elasticaObject->getId();
        }
        $orderedIds = array();
        foreach ($elasticaObjects as $position => $elasticaObject) {
            $orderedIds[$elasticaObject->getId()] = $position;
        }

        $blogEntries = $this->blogEntryRepository->findPublishedByIds($idsByType['blog']);
        $articles = $this->articleRepository->findPublishedByIds($idsByType['article']);
        $docs = array_merge($blogEntries->toArray(), $articles->toArray());

        usort($docs, function(Doc $a, Doc $b) use ($orderedIds) {
            return $orderedIds[$a->getId()] < $orderedIds[$b->getId()];
        });

        return $docs;
    }
}
