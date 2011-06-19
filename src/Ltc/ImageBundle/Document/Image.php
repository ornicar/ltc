<?php

namespace Ltc\ImageBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Ltc\FileBundle\Document\LtcFile;

/**
 * An image in a filesystem
 *
 * @MongoDB\EmbeddedDocument
 */
class Image extends LtcFile
{
    /**
     * Textual legend, can be used as image alternative
     *
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $legend;

    /**
     * Overwrite validation constraint
     *
     * @Assert\File(maxSize="4M",mimeTypes={"image/jpeg","image/png"})
     */
    protected $file;

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
}
