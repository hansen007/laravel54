<?php
/**
 * Created by Hansen.
 * User: Hansen
 * Date: 2019-06-17 15:45
 */

namespace App\Admin\Controllers;

use \App\Notice;

class NoticeController extends Controller
{

    //列表页
    public function index()
    {
        $notices = Notice::paginate(10);
        return view('admin/notice/index', compact('notices'));
    }

    //通知创建页
    public function create()
    {
        return view('admin/notice/add');
    }

    //通知保存
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $notice = \App\Notice::create(request(['title', 'content']));

        dispatch(new \App\Jobs\SendMessage($notice));

        return redirect("/admin/notices");
    }


}