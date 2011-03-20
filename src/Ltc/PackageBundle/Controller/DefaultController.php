<?php

namespace Ltc\PackageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcPackageBundle:Default:index.html.twig');
    }
}
