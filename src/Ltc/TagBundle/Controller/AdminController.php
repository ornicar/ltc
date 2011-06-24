<?php

namespace Ltc\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction()
    {
        $tags = $this->get('ltc_tag.repository.tag')->findAll();

        return $this->render('LtcTagBundle:Admin:index.html.twig', array(
            'tags' => $tags
        ));
    }

    public function listAction()
    {
        $titles = $this->get('ltc_tag.repository.tag')->findAllTitles();

        return new Response(json_encode($titles));
    }
}
