<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionGroup;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissionGroup = PermissionGroup::all();

        return view('admin.permissions.index', compact('permissionGroup'));
    }

    public function create(Request $request)
    {
        $check = Permission::where('name', $request->name)
                            ->where('group_id', $request->group_id)
                            ->first();

        if (empty($check)) {
            Permission::create($request->all());
        } else {
            return back()->with('error', 'Quyền truy cập này đã tồn tại');
        }

        return back()->with('success', 'Thêm thành công');
    }
}
