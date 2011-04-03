<?php

namespace Ltc\ImageBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FileField;
use Symfony\Component\Form\TextField;
use Ltc\ImageBundle\Uploader;

class ImageForm extends Form
{
    public function configure()
    {
        $this->setDataClass('Ltc\ImageBundle\Document\Image');
        $this->add(new FileField('file', array(
            'secret' => 's#cr#t'
        )));
        $this->add(new TextField('legend'));
    }

    public function upload(Uploader $uploader, $relativeDir = null)
    {
        $fileField = $this->get('file');
        if (!$fileField->getData()) {
            return;
        }
        $file = $uploader->upload($fileField->getData(), $fileField->getOriginalName(), $relativeDir);
        $this->getData()->setPath($file->getWebPath());
    }
}
