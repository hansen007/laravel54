<?php
/**
 * Created by Hansen.
 * User: Hansen
 * Date: 2019-06-17 15:45
 */

namespace App\Admin\Controllers;

use \App\AdminUser;

class UserController extends Controller
{

    //管理员列表页
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('admin/user/index',compact('users'));
    }

    //管理员创建页
    public function create()
    {
        return view('admin/user/add');
    }

    //管理员保存
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|min:3',
            'password' => 'required'
        ]);

        $name = request('name');
        $password = bcrypt(request('password'));
        AdminUser::create(compact('name','password'));

        return redirect("/admin/users");
    }

    //用户角色页面
    public function role(\App\AdminUser $user){
        $roles = \App\AdminRole::all();
        $myRoles = $user->roles;
        return view('admin/user/role',compact('roles','myRoles','user'));
    }

    //用户保存角色
    public function storeRole(\App\AdminUser $user){
        $this->validate(request(),[
            'roles' => 'required|array',
        ]);
        //通过roles数组查找主键为roles的数据
        $roles = \App\AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;
        //要增加的角色
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $role){
            $user->assignRole($role);
        }
        //要删除的角色
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $role){
            $user->deleteRole($role);
        }
        return back();
    }

}