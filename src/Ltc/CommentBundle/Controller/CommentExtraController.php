<?php

namespace Ltc\CommentBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentExtraController extends ContainerAware
{
    public function recentAction()
    {
        $comments = $this->getRecentComments(3);

        return $this->container->get('templating')->renderResponse('LtcCommentBundle:Comment:recent.html.twig', array(
            'comments'     => $comments
        ));
    }

    public function feedAction()
    {
        $comments = $this->getRecentComments(40);

        return $this->container->get('templating')->renderResponse('LtcCommentBundle:Comment:feed.xml.twig', array(
            'comments' => $comments
        ));
    }

    protected function getRecentComments($number)
    {
        return array_values($this->getCommentRepository()->createQueryBuilder()
            ->sort('createdAt', 'desc')
            ->limit($number)
            ->getQuery()
            ->execute()
            ->toArray());
    }

    protected function getCommentRepository()
    {
        return $this->container->get('doctrine.odm.mongodb.document_manager')->getRepository('Ltc\CommentBundle\Document\Comment');
    }
}
