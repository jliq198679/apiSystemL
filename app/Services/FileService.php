<?php

namespace App\Services;

use App\Library\StoreFile;

class FileService
{
    private $storeFile;
    public function __construct(StoreFile $storeFile)
    {
        $this->storeFile = $storeFile;
        $this->storeFile->setNameDisk('public');
    }
    public function upload($file)
    {
        $namefile = $this->storeFile->save($file);
        $url = $this->storeFile->getUrlFile($namefile);
        return $url;
    }
}
