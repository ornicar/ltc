<?php

namespace Ltc\ImportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcImportBundle:Default:index.html.twig');
    }
}
