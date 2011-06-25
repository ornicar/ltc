<?php

namespace Ltc\CoreBundle\Search;

use FOQ\ElasticaBundle\Transformer\ElasticaToModelTransformerInterface;
use Elastica_Searchable;
use Elastica_Query;

/**
 * Finds only one document if the score is high enough
 */
class SingleMatchFinder
{
    protected $searchable;
    protected $transformer;

    public function __construct(Elastica_Searchable $searchable, ElasticaToModelTransformerInterface $transformer)
    {
        $this->searchable  = $searchable;
        $this->transformer = $transformer;
    }

    public function findOneWithMinScore($query, $minScore)
    {
        $queryObject = Elastica_Query::create($query);
        $queryObject->setLimit(1);
        $results = $this->searchable->search($queryObject)->getResults();
        if (empty($results)) {
            return null;
        }
        $result = reset($results);
        if ($result->getScore() < $minScore) {
            return null;
        }
        $transformed = $this->transformer->transform($results);

        return reset($transformed);
    }
}
