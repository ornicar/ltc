<?php

namespace Ltc\FileBundle\Twig;

use Ltc\FileBundle\Document\LtcFile;

/**
 * Extends Twig to provide some helper functions for the FileBundle.
 */
class LtcFileExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    protected $filesystemWebPaths;

    /**
     * @param FilesystemMap $filesystemMap
     */
    public function __construct(array $filesystemWebPaths)
    {
        $this->filesystemWebPaths = $filesystemWebPaths;
    }

    /**
     * @return array An array of global filters
     */
    public function getFilters()
    {
        return array(
            'ltc_file' => new \Twig_Filter_Method($this, 'getPublicPath')
        );
    }

    /**
     * Gets the public path of a LtcFile instance
     *
     * @return string
     */
    public function getPublicPath(LtcFile $file)
    {
        $filesystem = $file->getFilesystem();
        if (!isset($this->filesystemWebPaths[$filesystem])) {
            throw new \InvalidArgumentException(sprintf('Unknown filesystem "%s"', $filesystem));
        }

        return sprintf('%s/%s', $this->filesystemWebPaths[$filesystem], $file->getPath());
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ltc_file';
    }
}
