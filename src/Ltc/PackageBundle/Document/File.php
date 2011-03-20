<?php

namespace Ltc\PackageBundle\Document;

use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

/**
 * @mongodb:EmbeddedDocument
 */
class File
{
    /**
     * Title of the file. Not the filename
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $title;

    /**
     * Real name on the file on filesystem
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $filename;

    /**
     * Absolute filesystem path
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $path;

    /**
     * Relative web path
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $webPath;

    /**
     * Extension of the file
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $extension;

    /**
     * Size of the file in bytes
     *
     * @var int
     * @mongodb:Field(type="int")
     */
    protected $size;

    /**
     * Incremental version of the file
     *
     * @var int
     * @mongodb:Field(type="int")
     */
    protected $version = 0;

    /**
     * Populate the document using a symfony file
     *
     * @param SymfonyFile $file
     */
    public function setFile(SymfonyFile $file)
    {
        $this->version++;
        $this->extension    = $file->getExtension();
        $this->size         = $file->getSize();
        $this->path         = $file->getPath();
        $this->webPath      = $file->getWebPath();
        $this->filename     = $file->getName();
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return $this->webPath;
    }

    /**
     * @param  string
     * @return null
     */
    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;
    }
    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param  string
     * @return null
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param  string
     * @return null
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param  int
     * @return null
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param  int
     * @return null
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param  string
     * @return null
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  string
     * @return null
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
