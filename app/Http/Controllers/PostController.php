<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Comment;

class PostController extends Controller
{

    /**
     * 渲染文章列表视图
     * @return view 分页后的文章列表页
     */
    public function index()
    {
        //使用withCount方法关联评论模型并统计结果数
        $posts = Post::withCount(['comments','likes'])
                ->orderBy('created_at','desc')->paginate(5);
    	return view("post/index",compact("posts"));
    }

    /**
     * 渲染文章详情视图
     * @param  Post   $post 给定ID匹配的整个Post模型实例
     * @return view         该文章的详情视图
     */
    public function show(Post $post)
    {
        //预加载关联模型
        // $post->load('comments'); 
        $post = Post::with('comments')->where('id','=',$post->id)->first();
    	return view('post/show',compact("post"));
    }

    /**
     * 渲染创建文章页面
     * @return view 创建文章页面
     */
    public function create()
    {
    	return view("post/create");
    }

    /**
     * 创建文章
     * @param  Request $request 创建文章的POST请求
     * @return view             重定向到文章列表页
     */
    public function store(Request $request)
    {
	    $validatedData = $request->validate([
	        'title' => 'required|string|max:255|min:5',
	        'content' => 'required|string|min:10',
	    ]);

        $user_id = Auth::id();
        $params = array_merge( $request->only(['title','content']),compact('user_id') );
    	
        // Post::create( $request->only(['title','content']) );
        Post::create( $params ); 
    	return redirect("/posts");
    }

    /**
     * 渲染编辑文章视图
     * @param  Post   $post 给定ID匹配的整个Post模型实例
     * @return view         编辑文章页面
     */
    public function edit(Post $post)
    {
    	return view('post/edit',compact('post'));
    }

    /**
     * 更新文章
     * @param  Request $request PUT请求
     * @param  Post    $post    给定ID匹配的整个Post模型实例   
     * @return view             重定向到该文章详情页
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        // 当前用户可以更新博客...
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|min:5',
            'content' => 'required|string|min:10',
        ]);
        
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        return redirect("/posts/{$post->id}");
    }

    //GET请求的删除
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);
        // 当前用户可以删除博客...
        
        $post->delete();
        //重定向到GET请求的/posts路由
        //redirect($to = null, $status = 302, $headers = [], $secure = null);
        return redirect("/posts");
    }

    /**
     * 处理图片上传
     * @return JSON 携带errno和data的数据
     */
    public function imageUpload(Request $request)
    {
    	//store()指定目录名 和 使用的磁盘 返回包含文件名的路径
    	$path = $request->file('wangEditorH5File')->store(time(),'public');

	    //asset函数使用当前请求的协议（ HTTP 或 HTTPS ）为资源文件生成 URL
	    $data = explode(' ', asset('storage/' . $path) );
	    return ['errno' => 0, 'data' => $data];
    }

    /**
     * 利用Scout实现全文搜索 使用Elasticsearch驱动
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function search(Request $request)
    {
        //验证
        $validatedData = $request->validate([
            'query' => 'required',
        ]);

        //逻辑
        $query = request('query');
        $posts = Post::search($query)->paginate(5);
        //渲染
        return view('post/search',compact('posts','query'));
    }
}