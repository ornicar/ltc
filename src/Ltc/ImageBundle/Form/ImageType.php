<?php

namespace Ltc\ImageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        return $builder
            ->add('file', 'file')
            ->add('legend', 'text');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\ImageBundle\Document\Image',
        );
    }
}
