<?php
/**
 * Created by Hansen.
 * User: Hansen
 * Date: 2019-06-17 15:45
 */

namespace App\Admin\Controllers;

use \App\AdminRole;

class RoleController extends Controller
{

    //角色列表页
    public function index()
    {
        $roles = AdminRole::paginate(10);
        return view('admin/role/index', compact('roles'));
    }

    //角色创建页
    public function create()
    {
        return view('admin/role/add');
    }

    //角色保存
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        AdminRole::create(request(['name', 'description']));

        return redirect("/admin/roles");
    }

    // 角色的权限列表
    public function permission(\App\AdminRole $role)
    {
        $permissions = \App\AdminPermission::all();
        $myPermissions = $role->permissions;
        return view('admin/role/permission',compact('permissions','myPermissions','role'));
    }

    //保存角色权限
    public function storePermission(\App\AdminRole $role)
    {
        $this->validate(request(),[
            'permissions' => 'required|array',
        ]);
        //通过permissions数组查找主键为permissions的数据
        $permissions = \App\AdminPermission::findMany(request('permissions'));
        $myPermissions = $role->permissions;
        //要增加的权限
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $permission){
            $role->grantPermission($permission);
        }
        //要删除的权限
        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $permission){
            $role->deletePermission($permission);
        }
        return back();
    }

}