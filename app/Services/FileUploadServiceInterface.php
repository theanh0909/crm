<?php

namespace App\Services;

interface FileUploadServiceInterface extends BaseServiceInterface
{
    public function upload($path, $fileName = '', $dataFile);
}
