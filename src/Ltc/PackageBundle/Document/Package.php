<?php

namespace Ltc\PackageBundle\Document;

/**
 * @mongodb:EmbeddedDocument
 */
class Package
{
    /**
     * Package title
     *
     * @var string
     * @mongodb:Field(type="string")
     */
    protected $title;

    /**
     * Files provided by the package
     *
     * @var array
     * @mongodb:EmbedMany(targetDocument="Ltc\PackageBundle\Document\File")
     */
    protected $files;

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param  array
     * @return null
     */
    public function setFiles($files)
    {
        $this->files = $files;
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
