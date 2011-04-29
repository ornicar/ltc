<?php

namespace Ltc\CoreBundle\Search;

use FOQ\ElasticaBundle\Paginator\DoctrinePaginatorAdapter;
use FOQ\ElasticaBundle\Transformer\ElasticaToModelTransformerInterface;
use Zend\Paginator\Paginator;
use Elastica_Index;
use Elastica_Query;

class Finder
{
    protected $index;
    protected $transformer;

    public function __construct(Elastica_Index $index, ElasticaToModelTransformerInterface $transformer)
    {
        $this->index       = $index;
        $this->transformer = $transformer;
    }

    /**
     * Gets a paginator wrapping the result of a search
     *
     * @return Paginator
     **/
    public function findPaginated($query)
    {
		$query = Elastica_Query::create($query);
		$paginatorAdapter = new DoctrinePaginatorAdapter($this->index, $query, $this->transformer);
		$paginator = new Paginator($paginatorAdapter);

		return $paginator;
    }
}
