<?php

namespace Ltc\FileBundle\Document;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A file in the filesystem
 *
 * @MongoDB\EmbeddedDocument
 */
class LtcFile
{
    /**
     * Path relative to the filesystem
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $path;

    /**
     * Filesystem name
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $filesystem;

    /**
     * Uploaded file
     * Not persisted: it's used in form and validation only
     *
     * @var UploadedFile
     * @Assert\File(maxSize="8M")
     */
    protected $uploadedFile;

    /**
     * Tells the document that the uploaded file has been moved
     *
     * @param string $path
     */
    public function upload($path, $filesystem)
    {
        $this->path = $path;
        $this->filesystem = $filesystem;
        $this->uploadedFile = null;
    }

    /**
     * Gets the uploaded file (which is not persisted, it's just for form purpose)
     *
     * @return UploadedFile or null
     **/
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * Tells if a file has been uploaded
     *
     * @return boolean
     */
    public function hasUploadedFile()
    {
        return $this->uploadedFile !== null;
    }

    /**
     * @return string
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @param  string
     * @return null
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
