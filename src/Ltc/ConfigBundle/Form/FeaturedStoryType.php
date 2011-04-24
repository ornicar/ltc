<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FeaturedStoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\ConfigBundle\Document\FeaturedStory',
        );
    }

    public function setStoryRepository(StoryRepository $storyRepository)
    {
        $field = new ChoiceField('story', array(
            'choices' => $storyRepository->findAll()->toArray()
        ));
        $field->setValueTransformer(new DoctrineObjectTransformer($storyRepository));
        $this->add($field);
    }
}
