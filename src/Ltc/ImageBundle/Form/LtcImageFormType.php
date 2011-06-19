<?php

namespace Ltc\ImageBundle\Form;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;

class LtcImageFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('legend', 'text')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\ImageBundle\Document\Image',
            'filesystem' => 'images'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'ltc_file';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ltc_image';
    }
}
