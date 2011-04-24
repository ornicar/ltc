<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Ltc\ImageBundle\Form\ImageType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('body', 'textarea')
            ->add('summary', 'textarea')
            ->add('publications', 'textarea')
            ->add('image', new ImageType());
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\ConfigBundle\Document\Author',
        );
    }
}
