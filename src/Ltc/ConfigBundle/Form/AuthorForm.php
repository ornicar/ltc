<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Ltc\ImageBundle\Form\ImageForm;

class AuthorForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('title'));
        $this->add(new TextareaField('body'));
        $this->add(new TextareaField('summary'));
        $this->add(new TextareaField('publications'));
        $this->add(new ImageForm('image'));
    }
}
