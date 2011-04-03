<?php

namespace Ltc\ArticleBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\Form\CheckboxField;
use Symfony\Component\Form\ChoiceField;
use Ltc\CoreBundle\Form\ValueTransformer\DoctrineObjectTransformer;
use Ltc\ArticleBundle\Document\CategoryRepository;
use Ltc\TagBundle\Document\TagRepository;
use Ltc\TagBundle\Form\ValueTransformer\TagsValueTransformer;
use Ltc\UserBundle\Document\UserRepository;
use Ltc\ImageBundle\Form\ImageForm;

class ArticleForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('title'));
        $this->add(new CheckboxField('isPublished'));
        $this->add(new TextareaField('summary'));
        $this->add(new TextareaField('body'));
        $this->add(new TextareaField('tags'));
        $this->add(new TextareaField('reference'));
        $this->add(new TextField('url'));
        $this->add(new TextField('authorName'));
        $this->add(new TextField('authorBio'));
        $this->add(new TextField('publicationDate'));
        $this->add(new TextareaField('relatedPublications'));
        $this->add(new ImageForm('image'));
    }

    public function addCategoryChoice(CategoryRepository $categoryRepository)
    {
        $field = new ChoiceField('category', array(
            'choices' => $categoryRepository->findAll()->toArray()
        ));
        $field->setValueTransformer(new DoctrineObjectTransformer($categoryRepository));
        $this->add($field);
    }

    public function addTags(TagRepository $tagRepository)
    {
        $field = new TextareaField('tags');
        $field->setValueTransformer(new TagsValueTransformer($tagRepository));
        $this->add($field);
    }
}
