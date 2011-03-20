<?php

namespace Ltc\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcBlogBundle:Default:index.html.twig');
    }
}
