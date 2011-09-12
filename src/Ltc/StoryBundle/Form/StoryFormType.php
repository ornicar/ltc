<?php

namespace Ltc\StoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class StoryFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => "Titre"))
            ->add('summary', 'textarea', array('label' => "Résumé"))
            ->add('body', 'textarea', array('label' => "Texte"))
            ->add('authorName', null, array('label' => "Nom de l'auteur"))
        ;
    }

    public function getName()
    {
        return 'story';
    }
}
