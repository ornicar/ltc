<?php

namespace Ltc\ImageBundle;

use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FileField;
use InvalidArgumentException;

/**
 * Uploads a file
 */
class Uploader
{
    /**
     * Base absolute directory on the server, where to upload the files
     *
     * @var string
     */
    protected $baseUploadDir = null;

    protected $filesystem;

    /**
     * Instanciates a new Uploader
     *
     * @param string baseUploadDir
     */
    public function __construct(Filesystem $filesystem, $baseUploadDir)
    {
        $this->filesystem = $filesystem;
        $this->baseUploadDir = $baseUploadDir;

        if (!is_dir($this->baseUploadDir)) {
            throw new InvalidArgumentException(sprintf('The base upload directory "%s" does not exist', $this->baseUploadDir));
        }
    }

    /**
     * Uploads a file
     *
     * @param string $file temp dir of the file
     * @param string $originalName name of the uploaded file
     * @param string $relativeDir optional directory to add the the base upload dir
     * @return File object representing the moved file
     **/
    public function upload($file, $originalName, $relativeDir = null)
    {
        $file = new File($file);
        $uploadDir = $this->baseUploadDir;
        if ($relativeDir) {
            $uploadDir .= '/'.$relativeDir;
        }
        if (!$this->filesystem->mkdir($uploadDir)) {
            throw new InvalidArgumentException(sprintf('Can not create the upload directory "%s"', $uploadDir));
        }
        $uploadDir = realpath($uploadDir);
        $filename = $uploadDir.'/'.$originalName;
        $filename = $this->findUniqueFilename($filename);
        $file->move(dirname($filename), basename($filename));

        return $file;
    }

    /**
     * Finds a unique, available file name in this directory
     *
     * @return string
     **/
    public function findUniqueFilename($file)
    {
        $candidate = $file;
        $it = 1;
        while (file_exists($candidate)) {
            $it++;
            $pathinfo = pathinfo($file);
            $candidate = sprintf('%s/%s-%d%s',
                $pathinfo['dirname'],
                $pathinfo['filename'],
                $it,
                empty($pathinfo['extension']) ? '' : '.'.$pathinfo['extension']
            );
        }

        return $candidate;
    }

    /**
     * Sets: Base absolute directory on the server, where to upload the files
     *
     * @param string baseUploadDir
     */
    public function setBaseUploadDir($baseUploadDir)
    {
        $this->baseUploadDir = $baseUploadDir;
    }
}
