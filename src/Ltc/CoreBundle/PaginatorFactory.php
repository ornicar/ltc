<?php

namespace Ltc\CoreBundle;

use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;
use Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Paginates queries
 */
class PaginatorFactory
{
    /**
     * pagination options
     *
     * @var array
     */
    protected $options = array(
        'item_count_per_page' => 10
    );

    /**
     * Instanciates a new PaginatorFactory
     *
     * @param array options
     */
    public function __construct(array $options = array())
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Transforms a query builder into a paginator
     *
     * @return Paginator
     **/
    public function paginate(QueryBuilder $queryBuilder, $page)
    {
        $paginator = new Pagerfanta(new DoctrineODMMongoDBAdapter($queryBuilder));
        $this->configurePaginator($paginator, $page);

        return $paginator;
    }

    /**
     * Configures an existing paginator
     *
     * @return null
     **/
    public function configurePaginator(Pagerfanta $paginator, $page, array $options = array())
    {
        $options = array_merge($this->options, $options);
        $paginator->setMaxPerPage($options['item_count_per_page']);
        $paginator->setCurrentPage($page);
    }
}
