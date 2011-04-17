<?php

namespace Bundle\ExerciseCom\FoodBundle\Search;

use FOQ\ElasticaBundle\Paginator\DoctrinePaginatorAdapter;
use FOQ\ElasticaBundle\MapperInterface;
use Zend\Paginator\Paginator;
use Elastica_Type;
use Elastica_Query;

class Finder
{
    protected $type;
    protected $mapper;

    public function __construct(Elastica_Type $type, MapperInterface $mapper)
    {
        $this->type   = $type;
        $this->mapper = $mapper;
    }

    /**
     * Search for a query string in the food type
     *
     * @return array of Food documents
     **/
    public function quickFind($query, $limit)
    {
        $queryObject = new Elastica_Query(new Elastica_Query_QueryString($query));
        $queryObject->setLimit($limit);
        $results = $this->type->search($query)->getResults();

        return $this->mapper->fromElasticaObjects($results);
    }

    /**
     * Gets a paginator wrapping the result of a search
     *
     * @return Paginator
     **/
    public function findPaginated($query)
    {
		$query = Elastica_Query::create($query);
		$paginatorAdapter = new DoctrinePaginatorAdapter($this->type, $query, $this->mapper);
		$paginator = new Paginator($paginatorAdapter);

		return $paginator;
    }
}
