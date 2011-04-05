<?php

namespace Ltc\ArticleBundle\Form;

use Ltc\DocBundle\Form\DocForm;
use Symfony\Component\Form\ChoiceField;
use Symfony\Component\Form\TextField;
use Ltc\CoreBundle\Form\ValueTransformer\DoctrineObjectTransformer;
use Ltc\ArticleBundle\Document\CategoryRepository;

class ArticleForm extends DocForm
{
    public function configure()
    {
        parent::configure();

        $this->add(new TextField('publicationDate'));
    }

    public function addCategoryChoice(CategoryRepository $categoryRepository)
    {
        $field = new ChoiceField('category', array(
            'choices' => $categoryRepository->findAll()->toArray()
        ));
        $field->setValueTransformer(new DoctrineObjectTransformer($categoryRepository));
        $this->add($field);
    }
}
