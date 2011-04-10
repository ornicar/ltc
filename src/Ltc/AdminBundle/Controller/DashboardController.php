<?php

namespace Ltc\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcAdminBundle:Dashboard:index.html.twig');
    }

    public function managerAction()
    {
        return $this->render('LtcAdminBundle:FileManager:manager.html.twig');
    }
}
