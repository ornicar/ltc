<?php

namespace Ltc\ArticleBundle\Form;

use Ltc\DocBundle\Form\DocFormType;
use Symfony\Component\Form\FormBuilder;

class ArticleFormType extends DocFormType
{
    protected $showCategory;

    public function __construct($showCategory)
    {
        $this->showCategory = (bool) $showCategory;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('publicationDate', null, array('label' => "Date de publication"));

        if ($this->showCategory) {
            $builder->add('category', null, array('label' => "Déplacer vers"));
        }
    }
}
