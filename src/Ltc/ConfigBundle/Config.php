<?php

namespace Ltc\ConfigBundle;

use Doctrine\ODM\MongoDB\DocumentRepository;

class Config
{
    protected $repository;
    protected $formFactory;
    protected $name;
    protected $title;

    /**
     * Instanciates a config
     *
     * @return null
     **/
    public function __construct(DocumentRepository $repository, FormFactory $formFactory, $name, $title)
    {
        $this->repository  = $repository;
        $this->formFactory = $formFactory;
        $this->name        = $name;
        $this->title       = $title;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getForm()
    {
        return $this->formFactory->create();
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
