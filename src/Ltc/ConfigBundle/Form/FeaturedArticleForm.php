<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\ChoiceField;
use Symfony\Component\Form\TextField;
use Ltc\ArticleBundle\Document\ArticleRepository;
use Ltc\CoreBundle\Form\ValueTransformer\DoctrineObjectTransformer;

class FeaturedArticleForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('title'));
    }

    public function setArticleRepository(ArticleRepository $articleRepository)
    {
        $field = new ChoiceField('article', array(
            'choices' => $articleRepository->findAllPublishedSortByCategory()->toArray()
        ));
        $field->setValueTransformer(new DoctrineObjectTransformer($articleRepository));
        $this->add($field);
    }
}
