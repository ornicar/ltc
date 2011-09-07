<?php

namespace Ltc\StoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class StoryFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('summary', 'textarea')
            ->add('body', 'textarea')
            ->add('authorName')
        ;
    }

    public function getName()
    {
        return 'story';
    }
}
