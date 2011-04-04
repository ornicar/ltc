<?php

namespace Ltc\StoryBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\Form\CheckboxField;

class StoryForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('title'));
        $this->add(new CheckboxField('isPublished'));
        $this->add(new TextareaField('body'));
        $this->add(new TextField('url'));
        $this->add(new TextField('authorName'));
    }
}
