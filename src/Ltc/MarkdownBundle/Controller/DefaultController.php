<?php

namespace Ltc\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LtcMarkdown:Default:index.html.twig');
    }
}
