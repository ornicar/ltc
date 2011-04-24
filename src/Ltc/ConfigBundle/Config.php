<?php

namespace Ltc\ConfigBundle;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Form\FormTypeInterface;

class Config
{
    protected $repository;
    protected $formType;
    protected $name;
    protected $title;

    /**
     * Instanciates a config
     *
     * @return null
     **/
    public function __construct(DocumentRepository $repository, FormTypeInterface $formType, $name, $title)
    {
        $this->repository = $repository;
        $this->formType   = $formType;
        $this->name       = $name;
        $this->title      = $title;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getFormType()
    {
        return $this->formType;
    }

    public function getDocument()
    {
        $document = $this->repository->findOneBy(array());
        if (!$document) {
            $class = $this->repository->getDocumentName();
            $document = new $class();
        }

        return $document;
    }
}
