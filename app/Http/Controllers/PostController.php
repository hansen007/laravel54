<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Post;
use \App\Comment;
use \App\Zan;

class PostController extends Controller
{
    //列表页面
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments','zans'])->with('user')->paginate(6);
//        $posts->load('user');

        return view("post/index", compact('posts'));
    }

    //详情页面
    public function show(Post $post)
    {
        $post->load('comments');
        return view("post/show", compact('post'));
    }

    //创建页面
    public function create()
    {
        return view("post/create");
    }

    //创建逻辑
    public function store()
    {
        //表单验证
        $this->validate(request(), [
            'content' => 'required|string|min:10'
        ]);
        //逻辑
        $user_id = \Auth::id();

        $params = array_merge(request(['title', 'content']), compact('user_id'));
        $post = Post::create($params);
//        $log = DB::connection('posts')->getQueryLog();
//        dd($log);
        return redirect("/posts");
        //dd(\Request::all());dump and die
//        dd(request()->all());
    }

    //编辑页面
    public function edit(Post $post)
    {
        return view("post/edit", compact('post'));
    }

    //编辑逻辑
    public function update(Post $post)
    {
        //表单验证
        $this->validate(request(), [
            'title' => 'required|string|min:2',
            'content' => 'required|string|min:10'
        ]);

        $this->authorize('update', $post);
        //逻辑
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        //渲染
        return redirect("/posts/{$post->id}");
    }

    //删除逻辑
    public function delete(Post $post)
    {
        //用户权限验证
        $this->authorize('delete', $post);
        $post->delete();
        return redirect("/posts");
    }

    //上传图片
    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
    }

    //提交评论
    public function comment(Post $post)
    {
        //  验证
        $this->validate(request(), [
            'content' => 'required|min:3'
        ]);
        //　逻辑
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        $post->comments()->save($comment);
        //  渲染
        return back();
    }

    // 赞
    public function zan(Post $post)
    {
        $params = [
            'user_id' => \Auth::id(),
            'post_id'=>$post->id,
        ];
        Zan::firstOrCreate($params);
        return back();
    }

    // 取消赞
    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
        return back();
    }

    //搜索结果页
    public function search(){
        //验证
        $this->validate(request(),[
            'query' => 'required'
        ]);
        //逻辑
        $query = request('query');
        $posts = \App\Post::search($query)->paginate(2);
        //渲染
        return view("post/search",compact('posts','query'));
    }
}
