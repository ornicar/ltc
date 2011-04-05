<?php

namespace Ltc\CommentBundle\FormFactory;

use Symfony\Component\Form\TextField;
use FOS\CommentBundle\FormFactory\CommentFormFactory as BaseCommentFormFactory;

class CommentFormFactory extends BaseCommentFormFactory
{
    public function createForm()
    {
        $form = parent::createForm();
        $form->add(new TextField('authorName'));

        return $form;
    }
}
