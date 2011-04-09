<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\ChoiceField;
use Ltc\StoryBundle\Document\StoryRepository;
use Ltc\CoreBundle\Form\ValueTransformer\DoctrineObjectTransformer;

class FeaturedStoryForm extends Form
{
    public function configure()
    {
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
