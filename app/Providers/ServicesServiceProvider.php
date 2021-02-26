<?php

namespace App\Providers;

use App\Services\FileUploadServiceInterface;
use App\Services\Production\FileUploadService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    private $services = [
        FileUploadServiceInterface::class  => FileUploadService::class,
    ];

    public function boot()
    {
        foreach ($this->services as $interface => $production) {
            $this->app->singleton($interface, $production);
        }
    }
}
