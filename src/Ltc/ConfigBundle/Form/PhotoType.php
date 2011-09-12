<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Ltc\ImageBundle\Form\ImageType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => "Nom"))
            ->add('image', 'ltc_image')
            ->add('url', 'text');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\ConfigBundle\Document\Photo',
        );
    }

    public function getName()
    {
        return 'article';
    }
}
