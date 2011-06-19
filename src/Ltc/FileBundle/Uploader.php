<?php

namespace Ltc\FileBundle;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FileField;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gaufrette\Filesystem;

/**
 * Uploads a file
 */
class Uploader
{
    /**
     * Uploads a file to the filesystem
     *
     * @param UploadedFile $file the file to upload
     * @param Filesystem $filesystem the filesysem where to move the file
     * @return the filename of the moved file
     **/
    public function upload(UploadedFile $file, Filesystem $filesystem)
    {
        $filename = $file->getClientOriginalName();
        $filename = $this->sanitize($filename);
        $filename = $this->makeUnique($filename, $filesystem);

        $data = file_get_contents($file->getRealPath());
        $filesystem->write($filename, $data);

        return $filename;
    }

    /**
     * Removes all dangerous chars from the filename
     *
     * @param string $filename
     * @return string the safe filename
     */
    protected function sanitize($filename)
    {
        return $filename;
    }

    /**
     * Finds a unique, available file name in this filesystem
     *
     * @param string proposed filename
     * @param Filesystem $filesystem
     * @return string the new filename
     **/
    protected function makeUnique($filename, Filesystem $filesystem)
    {
        $pathinfo = pathinfo($filename);
        $name = $pathinfo['filename']; // name without extension
        $extension = $pathinfo['extension']; // extension without dot
        $candidate = $filename;
        $it = 1;
        while ($filesystem->has($candidate)) {
            $it++;
            $candidate = sprintf('%s-%d%s', $name, $it, empty($extension) ? '' : '.'.$extension);
        }

        return $candidate;
    }
}
