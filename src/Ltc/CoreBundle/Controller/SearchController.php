<?php

namespace Ltc\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function searchAction()
    {
        $query = $this->get('request')->query->get('q', '');
        if ($query) {
            $results = $this->get('ltc_core.search_finder')->findPaginated($query);

            return $this->render('LtcCoreBundle:Search:results.html.twig', compact('query', 'results'));
        }

        return $this->render('LtcCoreBundle:Search:search.html.twig');
    }
}
