<?php

namespace Ltc\CoreBundle;

use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;
use ZendPaginatorAdapter\DoctrineMongoDBAdapter;
use Zend\Paginator\Paginator;
use Symfony\Component\HttpKernel\NotFoundHttpException;

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
        'item_count_per_page' => 10,
        'page_range' => 5
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
        $paginator = new Paginator(new DoctrineMongoDBAdapter($queryBuilder));
        $this->configurePaginator($paginator, $page);

        return $paginator;
    }

    /**
     * Configures an existing paginator
     *
     * @return null
     **/
    public function configurePaginator(Paginator $paginator, $page, array $options = array())
    {
        $options = array_merge($this->options, $options);
        $paginator->setItemCountPerPage($options['item_count_per_page']);
        $paginator->setPageRange($options['page_range']);
        if ($page > $paginator->count()) {
            throw new NotFoundHttpException('No more items');
        }
        $paginator->setCurrentPageNumber($page);
    }
}
