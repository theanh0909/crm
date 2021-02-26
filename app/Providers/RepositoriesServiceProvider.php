<?php

namespace App\Providers;

use App\Repositories\BaseRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\LicenseRepositoryInterface;
use App\Repositories\PermissionGroupRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\PermissionRoleRepositoryInterface;
use App\Repositories\PermissionUserRepositoryInterface;
use App\Repositories\Production\BaseRepository;
use App\Repositories\Production\CustomerRepository;
use App\Repositories\Production\LicenseRepository;
use App\Repositories\Production\PermissionGroupRepository;
use App\Repositories\Production\PermissionRepository;
use App\Repositories\Production\PermissionRoleRepository;
use App\Repositories\Production\PermissionUserRepository;
use App\Repositories\Production\ProductRepository;
use App\Repositories\Production\RoleRepository;
use App\Repositories\Production\UserRepository;
use App\Repositories\Production\UserRoleRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRoleRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    private $repositories = [
//        BaseRepositoryInterface::class              => BaseRepository::class,
        RoleRepositoryInterface::class              => RoleRepository::class,
        PermissionRepositoryInterface::class        => PermissionRepository::class,
        PermissionRoleRepositoryInterface::class    => PermissionRoleRepository::class,
        UserRepositoryInterface::class              => UserRepository::class,
        PermissionGroupRepositoryInterface::class   => PermissionGroupRepository::class,
        UserRoleRepositoryInterface::class          => UserRoleRepository::class,
        PermissionUserRepositoryInterface::class    => PermissionUserRepository::class,
        ProductRepositoryInterface::class           => ProductRepository::class,
        CustomerRepositoryInterface::class          => CustomerRepository::class,
        LicenseRepositoryInterface::class           => LicenseRepository::class,
    ];

    public function boot()
    {
        foreach ($this->repositories as $interface => $production) {
            $this->app->singleton($interface, $production);
        }
    }
}
