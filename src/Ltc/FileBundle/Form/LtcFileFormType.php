<?php

namespace Ltc\FileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Gaufrette\Filesystem;
use Knp\Bundle\GaufretteBundle\FilesystemMap;
use Ltc\FileBundle\Uploader;
use Ltc\FileBundle\Form\EventListener\FileUploadListener;

class LtcFileFormType extends AbstractType
{
    /**
     * @var Uploader
     */
    protected $uploader;

    /**
     * @var FilesystemMap
     */
    protected $filesystemMap;

    /**
     * @param Uploader $uploader
     * @param FilesystemMap $filesystemMap
     */
    public function __construct(Uploader $uploader, FilesystemMap $filesystemMap)
    {
        $this->uploader = $uploader;
        $this->filesystemMap = $filesystemMap;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        if (!$options['filesystem']) {
            throw new FormException('The option "filesystem" must be an name of Gaufrette\\Filesystem');
        }
        $filesystem = $this->getFilesystem($options['filesystem']);
        $listener = new FileUploadListener($this->uploader, $filesystem, $options['filesystem']);

        $builder
            ->add('uploadedFile', 'file')
            ->addEventSubscriber($listener)
        ;
    }

    /**
     * Gets a filesystem from the map
     *
     * @param string $name
     * @return Filesystem
     */
    protected function getFilesystem($name)
    {
        return $this->filesystemMap->get($name);
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Ltc\FileBundle\Document\LtcFile',
            'filesystem' => null
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ltc_file';
    }
}
