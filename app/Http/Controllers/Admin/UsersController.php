<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\ChangePasswordRequest;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Requests\Admin\Users\UpdatePasswordRequest;
use App\Http\Requests\Admin\Users\UpdateProfileRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Repositories\PermissionGroupRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\PermissionRoleRepositoryInterface;
use App\Repositories\PermissionUserRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRoleRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\RoleRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use App\Models\Transaction;
use App\Models\Customer;

class UsersController extends Controller
{
    protected $roleRepository;

    protected $permissionRepository;

    protected $permissionRoleRepository;

    protected $userRepository;

    protected $permissionGroupRepository;

    protected $userRoleRepository;

    protected $permissionUserRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository,
        PermissionRoleRepositoryInterface $permissionRoleRepository,
        UserRepositoryInterface $userRepository,
        PermissionGroupRepositoryInterface $permissionGroupRepository,
        UserRoleRepositoryInterface $userRoleRepository,
        PermissionUserRepositoryInterface $permissionUserRepository
    )
    {
        $this->roleRepository           = $roleRepository;
        $this->permissionRepository     = $permissionRepository;
        $this->permissionRoleRepository = $permissionRoleRepository;
        $this->userRepository           = $userRepository;
        $this->permissionGroupRepository = $permissionGroupRepository;
        $this->userRoleRepository       = $userRoleRepository;
        $this->permissionUserRepository = $permissionUserRepository;
    }

    public function profile($customerId)
    {
        $productUsed = Transaction::where('customer_id', $customerId)
                                  ->where('status', Transaction::STATUS_APPROVE)
                                  ->latest('id')
                                  ->paginate(20);
        $customer = Customer::find($customerId);

        return view('admin.customer.profile', compact('productUsed', 'customer'));
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'query'
        ]);

        $auth = auth()->user();
        if($auth->type == User::TYPE_ADMIN_USER) {
            $filters['type'] = User::TYPE_ADMIN_USER;
        }

        $users = $this->userRepository->filterPagination($filters,'20');

        return view('admin.users.index', compact(
            'users', 'filters'
        ));
    }

    public function create()
    {
        $permissionGroup = $this->permissionGroupRepository->allByFilter([]);
        $roles       = $this->roleRepository->allByFilter([]);

        return view('admin.users.create', compact(
            'permissionGroup', 'roles'
        ));
    }

    public function store(StoreRequest $request)
    {
        $inputs = $request->only([
            'name',
            'fullname',
            'email',
            'password',
            'roles',
            'permissions',
        ]);

        $inputs['password'] = Hash::make($inputs['password']);
        $inputs['type']     = User::TYPE_ADMIN_USER;

        $roles          = isset($inputs['roles']) ? $inputs['roles'] : [];
        $permissions    = isset($inputs['permissions']) ? $inputs['permissions'] : [];

        try {
            \DB::beginTransaction();
            $user = $this->userRepository->create($inputs);

            if(is_array($roles) && count($roles) > 0) {
                $user->attachRoles($roles);
            }

            if(is_array($permissions) && count($permissions) > 0) {
                $user->attachPermissions($permissions);
            }
            \DB::commit();

            return redirect()->route('admin.user.index')->with('success', 'Thêm user thành công');
        } catch (\Exception $e) {
            \DB::rollback();
            throw new Exception($e);
        }
    }

    public function edit($id)
    {
        $user        = $this->userRepository->firstBykey($id);
        $permissionGroup = $this->permissionGroupRepository->allByFilter([]);
        $roles       = $this->roleRepository->allByFilter([]);

        $hasPermissions = [];
        foreach($user->permissions as $permission) {
            $hasPermissions[$permission->id] = true;
        }

        $hasRoles = [];
        foreach($user->roles as $rrole) {
            $hasRoles[$rrole->id] = true;
        }

        return view('admin.users.edit', compact(
            'user', 'permissionGroup', 'roles', 'hasRoles', 'hasPermissions'
        ));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = $this->userRepository->firstByKey($id);
        if(!$user) {
            return redirect()->route('admin.user.index');
        }

        $inputs = $request->only([
            'name',
            'fullname',
            'email',
            'roles',
            'permissions',
            'password',
        ]);

        if(!empty($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        } else {
            unset($inputs['password']);
        }

        $roles          = isset($inputs['roles']) ? $inputs['roles'] : [];
        $permissions    = isset($inputs['permissions']) ? $inputs['permissions'] : [];


        try {
            $user = $this->userRepository->update($user, $inputs);

            $this->userRoleRepository->deleteByFilter(['user_id' => $user->id]);
            if(is_array($roles) && count($roles) > 0) {
                $user->attachRoles($roles);
            }



            $this->permissionUserRepository->deleteByFilter(['user_id' => $user->id]);
            if(is_array($permissions) && count($permissions) > 0) {
                $user->attachPermissions($permissions);
            }

            return redirect()->route('admin.user.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            throw new Exception($e);
        }
    }

    public function destroy($id)
    {
        $this->userRepository->deleteByFilter([
            'id' => $id
        ]);

        return redirect()->route('admin.user.index');
    }

    public function resetPassword()
    {
        return view('admin.users.reset_password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $userID = auth()->user()->id;
        $user = User::find($userID);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.index')->with('success', 'Đổi mật khẩu thành công!');
    }

    public function editProfile()
    {
        $user = auth()->user();
        
        return view('admin.users.profile', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $id = auth()->user()->id;
        $user = $this->userRepository->firstByKey($id);
        if(!$user) {
            return redirect()->route('admin.user.index');
        }

        $inputs = $request->only([
            'name',
            'fullname',
            'email',
            'password'
        ]);

        $inputs['password'] = Hash::make($inputs['password']);

        $file = $request->file('avatar');
        if($file) {
            $dataUpload = Storage::disk('local')->put("public/user/{$id}/", $file);
            $inputs['avatar'] = $dataUpload;
        }

        $user = $this->userRepository->update($user, $inputs);

        return redirect()->route('admin.index')->with('success', 'Update Profile thành công!');
    }

    public function postEditPassword($id, ChangePasswordRequest $request)
    {
        $user = User::where('id', $id)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with([
            'success' => "Đổi mật khẩu thành công!",
        ]);
    }
}
