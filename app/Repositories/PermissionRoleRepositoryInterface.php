<?php

namespace App\Repositories;

interface PermissionRoleRepositoryInterface extends BaseRepositoryInterface
{
    public function deleteByRole($roleID);
}
