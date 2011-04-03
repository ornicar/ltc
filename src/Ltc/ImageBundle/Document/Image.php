<?php

namespace Ltc\ImageBundle\Document;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * An image on the filesystem.
 * Can embed thumbnails, which are other image instances
 *
 * @mongodb:EmbeddedDocument
 */
class Image
{
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
     * Processor used to generate this image
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $processor;

    /**
     * Thumbnails of this image
     *
     * @var array
     * @mongodb:EmbedMany(targetDocument="Ltc\ImageBundle\Document\Image")
     **/
    protected $thumbnails;

    /**
     * Textual legend, can be used as image alternative
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $legend;

    /**
     * Uploaded file
     * Not persisted: it's used in form and validation only
     *
     * @var File
     * @assert:File(maxSize="4M",mimeTypes={
     *     "image/jpeg",
     *     "image/png"
     * })
     */
    public $file;

    public function __construct()
    {
        $this->thumbnails = new ArrayCollection();
    }

    public function update(File $file)
    {
        $this->version++;
        $this->path         = $file->getPath();
        $this->webPath      = $file->getWebPath();
        $this->clearThumbnails();
    }

    /**
     * Gets the uploaded file path (which is not persisted, it's just for form purpose)
     *
     * @return string
     **/
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * @param  string
     * @return null
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;
    }

    /**
     * @return string
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @param  string
     * @return null
     */
    public function setProcessor($processor)
    {
        $this->processor = $processor;
    }

    public function clearThumbnails()
    {
        $this->thumbnails->clear();
    }

    public function hasThumbnail($processor)
    {
        foreach($this->thumbnails as $thumbnail) {
            if($processor === $thumbnail->getProcessor()) {
                return true;
            }
        }

        return false;
    }

    public function getThumbnail($processor)
    {
        foreach($this->thumbnails as $thumbnail) {
            if($processor === $thumbnail->getProcessor()) {
                return $thumbnail;
            }
        }
    }

    public function setThumbnail(Image $thumbnail)
    {
        return $this->thumbnails->add($thumbnail);
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return $this->webPath;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
