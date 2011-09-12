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
            ->add('title', 'text', array('label' => "Nom"))
            ->add('body', 'textarea', array('label' => "Texte"))
            ->add('summary', 'textarea', array('label' => "Résumé"))
            ->add('publications', 'textarea', array('label' => "Publications"))
            ->add('image', 'ltc_image', array('label' => "Image"));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\ConfigBundle\Document\Author',
        );
    }

    public function getName()
    {
        return 'author';
    }
}
