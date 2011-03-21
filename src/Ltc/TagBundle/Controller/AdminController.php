<?php

namespace Ltc\TagBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcTagBundle:Admin:index.html.twig');
    }
}
