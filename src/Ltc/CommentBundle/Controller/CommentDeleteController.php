<?php

namespace Ltc\CommentBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentDeleteController extends ContainerAware
{
    public function deleteAction($commentId)
    {
        if (!$comment = $this->container->get('fos_comment.manager.comment')->findCommentById($commentId)) {
            throw new NotFoundHttpException('No comment found');
        }
        $comment->delete();
        $this->container->get('doctrine.odm.mongodb.document_manager')->flush();

        return new RedirectResponse($comment->getThread()->getPermalink());
    }
}
