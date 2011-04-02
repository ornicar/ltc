<?php

namespace Ltc\PackageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcPackage:Default:index.html.twig');
    }
}
