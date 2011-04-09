<?php

namespace Ltc\ConfigBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Ltc\ImageBundle\Form\ImageForm;

class PhotoForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('title'));
        $this->add(new ImageForm('image'));
        $this->add(new TextField('url'));
    }
}
