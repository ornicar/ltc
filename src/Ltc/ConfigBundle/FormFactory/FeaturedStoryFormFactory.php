<?php

namespace Ltc\ConfigBundle\FormFactory;

use Ltc\ConfigBundle\FormFactory;
use Ltc\StoryBundle\Document\StoryRepository;

class FeaturedStoryFormFactory extends FormFactory
{
    protected $storyRepository;

    public function setStoryRepository(StoryRepository $storyRepository)
    {
        $this->storyRepository = $storyRepository;
    }

    public function create(array $options = array())
    {
        $form = parent::create($options);
        $form->setStoryRepository($this->storyRepository);

        return $form;
    }
}
