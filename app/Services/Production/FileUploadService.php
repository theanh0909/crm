<?php

namespace App\Services\Production;

use App\Services\FileUploadServiceInterface;
use Illuminate\Support\Facades\File;

class FileUploadService extends BaseService implements FileUploadServiceInterface
{

    public function upload($path, $fileName = '', $dataFile)
    {
        $path = public_path() . "/{$path}";
        if(!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if($fileName == '') {
            $fileName = $dataFile->getClientOriginalName();
        }

        return $dataFile->storeAs($path, $fileName);
    }
}
