<?php

namespace FileBundle\Forms\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class FileUploadModel
{
    private $file;

    private $folder;

    private  $extension;

    private $size;

    public function __construct(array $extension = [], $folder = null)
    {
        $this->extension = $extension;
        $this->folder = $folder;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    /*
     * return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    public function getFolder()
    {
        return $this->folder;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }
}