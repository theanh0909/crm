<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\StoreRequest;
use App\Http\Requests\Admin\Roles\UpdateRequest;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\PermissionRoleRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\RoleRepositoryInterface;
use Mockery\Exception;
use App\Repositories\PermissionGroupRepositoryInterface;

class RolesController extends Controller
{
    protected $roleRepository;

    protected $permissionRepository;

    protected $permissionRoleRepository;

    protected $permissionGroupRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository,
        PermissionRoleRepositoryInterface $permissionRoleRepository,
        PermissionGroupRepositoryInterface $permissionGroupRepository
    )
    {
        $this->roleRepository           = $roleRepository;
        $this->permissionRepository     = $permissionRepository;
        $this->permissionRoleRepository = $permissionRoleRepository;
        $this->permissionGroupRepository = $permissionGroupRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'query'
        ]);

        $roles = $this->roleRepository->filterPagination($filters,'20');

        return view('admin.roles.index', compact(
            'roles', 'filters'
        ));
    }

    public function create()
    {
        $permissionGroup = $this->permissionGroupRepository->allByFilter([]);

        return view('admin.roles.create', compact(
            'permissionGroup'
        ));
    }

    public function store(StoreRequest $request)
    {
        $inputs = $request->only([
            'name',
            'display_name',
            'description',
            'permissions',
        ]);

        $permissions = isset($inputs['permissions']) ? $inputs['permissions'] : [];
        try {
            $role = $this->roleRepository->create($inputs);

            if(is_array($permissions) && count($permissions) > 0) {
                $role->attachPermissions($permissions);
            }

            return redirect()->route('admin.roles.create')->with('success', 'Tạo thành công');
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }

    public function edit($id)
    {
        $role        = $this->roleRepository->firstBykey($id);
        $permissionGroup = $this->permissionGroupRepository->allByFilter([]);

        $hasPermissions = [];
        foreach($role->permissions as $permission) {
            $hasPermissions[$permission->id] = true;
        }

        return view('admin.roles.edit', compact(
            'role', 'permissionGroup', 'hasPermissions'
        ));
    }

    public function update(UpdateRequest $request, $id)
    {
        $role = $this->roleRepository->firstByKey($id);
        if(!$role) {
            return redirect()->route('admin.roles.index');
        }

        $inputs = $request->only([
            'name',
            'display_name',
            'description',
            'permissions',
        ]);

        $permissions = isset($inputs['permissions']) ? $inputs['permissions'] : [];
        try {
            $role = $this->roleRepository->update($role, $inputs);

            $this->permissionRoleRepository->deleteByRole($id);
            if(is_array($permissions) && count($permissions) > 0) {
                $role->attachPermissions($permissions);
            }

            return redirect()->route('admin.roles.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }

    public function destroy($id)
    {
        $role = $this->roleRepository->firstByKey($id);
        $this->roleRepository->delete($role);

        return redirect()->route('admin.roles.index')->with('success', 'Xóa thành công');
    }
}
