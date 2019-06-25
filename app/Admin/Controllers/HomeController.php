<?php
/**
 * Created by Hansen.
 * User: Hansen
 * Date: 2019-06-17 16:38
 */

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //登陆页
    public function index()
    {
        return view('admin.home.index');
    }


}