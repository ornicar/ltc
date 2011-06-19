<?php

namespace Ltc\FileBundle\Doctrine;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Ltc\ImageBundle\Uploader;

class Listener
{
    /**
     * @var Uploader
     */
    protected $uploader;

    /**
     * @var string
     */
    protected $objectClass;

    /**
     * @param Uploader $uploader
     * @param string $objectClass
     */
    public function __construct(Uploader $uploader, $objectClass)
    {
        $this->uploader = $uploader;
        $this->objectClass = $objectClass;
    }

    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        if ($document instanceof $this->objectClass && $document->hasFile()) {
            $this->uploader->upload($file, 'image');
        }
    }

    public function postRemove(LifecycleEventArgs $eventArgs)
    {
        $this->process($eventArgs);
    }

    protected function process(LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();

        if ($document instanceof $this->objectClass && $document->hasBranding()) {
            $this->container->get('exercise_program.asset_dumper')->dump($document->getBranding());
        }
    }

    public function getSubscribedEvents()
    {
        return array('prePersist', 'postPersist', 'postRemove');
    }

}
