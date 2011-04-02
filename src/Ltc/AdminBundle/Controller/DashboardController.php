<?php

namespace Ltc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcAdmin:Dashboard:index.html.twig');
    }
}
