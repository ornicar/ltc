<?php

namespace Ltc\FileBundle\Form\EventListener;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\FilterDataEvent;
use Gaufrette\Filesystem;
use Ltc\FileBundle\Document\File;
use Ltc\FileBundle\Uploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Event\DataEvent;

/**
 * Renames an embedded image according to an object property
 */
class FileUploadListener implements EventSubscriberInterface
{
    /**
     * @var Uploader
     */
    protected $uploader;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $filesystemName;

    /**
     * @param Uploader $uploader
     * @param Filesystem $filesystem
     */
    public function __construct(Uploader $uploader, Filesystem $filesystem, $filesystemName)
    {
        $this->uploader = $uploader;
        $this->filesystem = $filesystem;
        $this->filesystemName = $filesystemName;
    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_BIND => 'onPostBind');
        return array(FormEvents::BIND_CLIENT_DATA => 'onBindClientData');
    }

    public function onPostBind(DataEvent $event)
    {
        $data = $event->getData();
        if (!$data->hasUploadedFile()) {
            return;
        }

        $path = $this->uploader->upload($data->getUploadedFile(), $this->filesystem);
        $data->upload($path, $this->filesystemName);
    }
}
