<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $images;


    public function __construct($imagesDirectory)
    {
        $this->images = $imagesDirectory;
    }

    public function getTargetDirectory($directory)
    {
        return $this->$directory;
    }
    public function upload(UploadedFile $file, $directory)
    {
        $fileName = 'images-'.uniqid().'.'.$file->guessExtension();
        try {
            $file->move(
                $this->getTargetDirectory($directory),
                $fileName
            );
        } catch (FileException $e) {
            return '';
        }
        return $fileName;
    }
    public function remove($filename, $directory)
    {
        $file = $this->getTargetDirectory($directory).'/'.$filename;
        return file_exists($file) ? unlink($file) : false;
    }
}
