<?php

namespace Ltc\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcUserBundle:Default:index.html.twig');
    }
}
