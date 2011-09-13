<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FeaturedArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title', 'text', array('label' => "Accroche"));
        $builder->add('switch', 'choice', array(
            'choices' => array(
                'article' => 'Article',
                'blog' => 'Table Ronde'
            ),
            'label' => "Switch",
            'expanded' => true
        ));
        $builder->add('article', null, array('label' => "Article"));
        $builder->add('blogEntry', null, array('label' => "Table Ronde"));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\ConfigBundle\Document\FeaturedArticle',
        );
    }

    public function getName()
    {
        return 'featured_article';
    }
}
