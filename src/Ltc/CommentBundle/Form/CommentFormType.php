<?php

namespace Ltc\CommentBundle\Form;

use FOS\CommentBundle\Form\CommentType as BaseCommentFormType;
use Symfony\Component\Form\FormBuilder;

class CommentFormType extends BaseCommentFormType
{
    /**
     * Configures a Comment form.
     *
     * @param FormBuilder $builder
     * @param array $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('authorName', 'text');
    }

    public function getName()
    {
        return 'comment';
    }
}
