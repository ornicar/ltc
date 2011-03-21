<?php

namespace Ltc\ImageBundle\ImageBundle;

use Bundle\ImagineBundle\Services\ProcessorManager;
use Doctrine\OdocumentManager\MongoDB\DocumentManager;
use Ltc\ImageBundle\Document\Image;

class ThumbnailManager
{
    protected $processorManager;
    protected $documentManager;
    protected $options = array(
        "quality" => 90
    );

    public function __construct(ProcessorManager $processorManager, DocumentManager $documentManager, array $options = array())
    {
        $this->processorManager = $processorManager;
        $this->documentManager  = $documentManager;
        $this->options          = array_merge($this->options, $options);
    }

    public function getThumbnail(Image $image, $processorName)
    {
        if(!$processorName) {
            return $image;
        }

        if($image->hasThumbnail($processorName)) {
            return $image->getThumbnail($processorName);
        }

        $thumbnail = $this->createThumbnail($image, $processorName);
        $image->setThumbnail($thumbnail);
        $this->documentManager->flush();

        return $thumbnail;
    }

    public function createThumbnail(Image $image, $processorName)
    {
        $processor = $this->processorManager->getProcessor($processorName);
        $file = $image->getPath();
        $resource = new \Imagine\Image($file);
        $processor->process($resource);

        $save = new \Imagine\GD\Command\Save($file, null, $this->options);
        $save->process($resource);

        $thumbnail = new Image();
        $thumbnail->setSymfonyFile($file);
        $thumbnail->setVersion($image->getVersion());
        $thumbnail->setProcessor($processorName);

        return $thumbnail;
    }
}
