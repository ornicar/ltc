<?php

namespace Ltc\CoreBundle\Search;

use Symfony\Component\HttpFoundation\Request;

class NotFoundSearch
{
    /**
     * @var SingleMatchFinder
     */
    protected $finder;

    /**
     * Score required for a good match
     *
     * @var int
     */
    protected $score;

    public function __construct(SingleMatchFinder $finder, $score)
    {
        $this->finder = $finder;
        $this->score = $score;
    }

    /**
     * Finds a good match for the request
     *
     * @return Doc or null if no good match
     */
    public function findGoodMatch(Request $request)
    {
        $query = str_replace(array('/', '-'), ' ', $request->getPathInfo());

        return $this->finder->findOneWithMinScore($query, $this->score / 100);
    }
}
