<?php

namespace App\Repositories\Production;


use App\Models\PermissionGroup;
use App\Repositories\PermissionGroupRepositoryInterface;

class PermissionGroupRepository extends BaseRepository implements PermissionGroupRepositoryInterface
{
    public function __construct(PermissionGroup $model)
    {
        parent::__construct($model);
    }
}
