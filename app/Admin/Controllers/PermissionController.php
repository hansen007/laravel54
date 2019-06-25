<?php
/**
 * Created by Hansen.
 * User: Hansen
 * Date: 2019-06-17 15:45
 */

namespace App\Admin\Controllers;

use \App\AdminPermission;

class PermissionController extends Controller
{

    //权限列表页
    public function index()
    {
        $permissions = AdminPermission::paginate(10);
        return view('admin/permission/index',compact('permissions'));
    }

    //权限创建页
    public function create()
    {
        return view('admin/permission/add');
    }

    //权限保存
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        AdminPermission::create(request(['name','description']));

        return redirect("/admin/permissions");
    }

}