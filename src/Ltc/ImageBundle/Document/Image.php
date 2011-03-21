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
     * @mongodb:String
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
     */
    protected $legend;

    public function __construct()
    {
        $this->thumbnails = new ArrayCollection();
    }

    /**
     * Populate the document using a symfony file
     *
     * @param SymfonyFile $file
     */
    public function setFile(File $file)
    {
        $this->version++;
        $this->path         = $file->getPath();
        $this->webPath      = $file->getWebPath();
        $this->clearThumbnails();
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
