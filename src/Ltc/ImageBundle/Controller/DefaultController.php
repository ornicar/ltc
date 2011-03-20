<?php

namespace Ltc\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcImageBundle:Default:index.html.twig');
    }
}
