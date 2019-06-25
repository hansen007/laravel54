<?php
/**
 * Created by Hansen.
 * User: Hansen
 * Date: 2019-06-17 16:38
 */

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

use \App\Post;

class PostController extends Controller
{
    //文章列表页
    public function index()
    {
        $posts = Post::withoutGlobalScope('avaiable')->where('status',0)->orderBy('created_at','desc')->paginate(10);
        return view('admin.post.index',compact('posts'));
    }


    public function status(Post $post)
    {
        $this->validate(request(),[
            'status' => 'required|in:-1,1'
        ]);
        $post->status = request('status');
        $post->save();
        return [
            'error'=>0,
            'msg'=>''
        ];
    }
}