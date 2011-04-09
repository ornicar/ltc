<?php

namespace Ltc\ConfigBundle\FormFactory;

use Ltc\ConfigBundle\FormFactory;
use Ltc\ArticleBundle\Document\ArticleRepository;

class FeaturedArticleFormFactory extends FormFactory
{
    protected $articleRepository;

    public function setArticleRepository(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function create(array $options = array())
    {
        $form = parent::create($options);
        $form->setArticleRepository($this->articleRepository);

        return $form;
    }
}
