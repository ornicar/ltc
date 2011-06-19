<?php

namespace Ltc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

abstract class DocFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('isPublished')
            ->add('summary', 'textarea')
            ->add('body', 'textarea')
            ->add('tags', 'ltc_tags')
            ->add('reference', 'textarea')
            ->add('authorName')
            ->add('authorBio')
            ->add('relatedPublications', 'textarea')
            ->add('readMore', 'textarea')
            ->add('image', 'ltc_image', array(
                'filesystem' => 'images'
            ))
        ;
    }
}
