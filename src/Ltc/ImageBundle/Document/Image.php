<?php

namespace Ltc\ImageBundle\Document;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * An image in the web dir.
 *
 * @mongodb:EmbeddedDocument
 */
class Image
{
    /**
     * Relative web path
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $path;

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
}
