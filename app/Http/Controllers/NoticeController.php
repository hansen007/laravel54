<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notice;

class NoticeController extends Controller
{
    //
    public function index(){
        $user = \Auth::user();
//        $notices=$user->notices;
//        $notices=$user->notices()->orderBy('created_at', 'desc')->take(10)->get();
        $notices=$user->notices()->orderBy('created_at', 'desc')->paginate(10);
        return view('notice/index',compact('notices'));
    }

}
