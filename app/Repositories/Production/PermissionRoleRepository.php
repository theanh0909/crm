<?php

namespace App\Repositories\Production;


use App\Models\PermissionRole;
use App\Repositories\PermissionRoleRepositoryInterface;

class PermissionRoleRepository extends BaseRepository implements PermissionRoleRepositoryInterface
{
    public function __construct(PermissionRole $model)
    {
        parent::__construct($model);
    }

    public function deleteByRole($roleID)
    {
        return $this->model->where('role_id', $roleID)->delete();
    }
}
