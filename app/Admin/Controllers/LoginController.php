<?php
/**
 * Created by Hansen.
 * User: Hansen
 * Date: 2019-06-17 16:38
 */

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function welcome(){
        return redirect('/admin/login');
    }

    //登陆页
    public function index()
    {
        return view('admin.login.index');
    }

    public function login()
    {
        //验证
        $this->validate(request(),[
            'name' => 'required|min:2',
            'password' => 'required|min:5|max:10',
        ]);

        //逻辑
        $user = request(['name','password']);
        if(\Auth::guard('admin')->attempt($user)){
            return redirect('/admin/home');
        }
        //渲染
        return \Redirect::back()->withErrors('用户名密码不匹配');
    }

    public function logout()
    {
        \Auth::guard("admin")->logout();
        return redirect('/admin/login');
    }
}