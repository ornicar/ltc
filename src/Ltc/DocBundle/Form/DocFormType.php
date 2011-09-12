<?php

namespace Ltc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

abstract class DocFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Titre'))
            ->add('isPublished', null, array('label' => "Visible sur le site"))
            ->add('summary', 'textarea', array('label' => "Résumé"))
            ->add('body', 'textarea', array('label' => "Texte"))
            ->add('tags', 'ltc_tags')
            ->add('reference', 'textarea', array('label' => "Référence"))
            ->add('authorName', null, array('label' => "Nom de l'auteur"))
            ->add('authorBio', null, array('label' => "Qualité de l'auteur"))
            ->add('relatedPublications', 'textarea', array('label' => "Publications liées"))
            ->add('readMore', 'textarea', array('label' => 'Téléchargements'))
            ->add('image', 'ltc_image')
        ;
    }

    public function getName()
    {
        return 'doc';
    }
}
