<?php

namespace Ltc\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcDocBundle:Default:index.html.twig');
    }
}
