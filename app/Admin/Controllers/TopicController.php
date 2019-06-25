<?php
/**
 * Created by Hansen.
 * User: Hansen
 * Date: 2019-06-17 15:45
 */

namespace App\Admin\Controllers;

use \App\Topic;

class TopicController extends Controller
{

    //列表页
    public function index()
    {
        $topics = Topic::paginate(10);
        return view('admin/topic/index', compact('topics'));
    }

    //专题创建页
    public function create()
    {
        return view('admin/topic/add');
    }

    //专题保存
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);

        Topic::create(request(['name']));

        return redirect("/admin/topics");
    }

    public function destroy(\App\Topic $topic)
    {
        $topic->delete();
        return [
            'error'=>0,
            'msg'=>''
        ];
    }

}