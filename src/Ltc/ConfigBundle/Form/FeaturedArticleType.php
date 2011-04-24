<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FeaturedArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', 'text');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\ConfigBundle\Document\FeaturedArticle',
        );
    }

    #TODO
    public function setArticleRepository(ArticleRepository $articleRepository)
    {
        $field = new ChoiceField('article', array(
            'choices' => $articleRepository->findAllPublishedSortByCategory()->toArray()
        ));
        $field->setValueTransformer(new DoctrineObjectTransformer($articleRepository));
        $this->add($field);
    }
}
