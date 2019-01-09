<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;
use App\Post;

class LikeController extends Controller
{
    /**
     * 点赞
     * @param  Post   $post 依赖注入的文章模型实例
     * @return Response       [description]
     */
    public function like(Post $post)
    {
    	$param = [
    		'user_id' => Auth::id(),
    		'post_id' => $post->id,
    	];
    	/**
    	 * firstOrCreate 方法将尝试使用给定的列/值来查找数据库。
    	 * 如果在数据库找不到该模型，则会从第一个参数的属性乃至第二个参数的属性中创建一条记录插入到数据库。
    	 */
		Like::firstOrCreate( $param );

    	return back();
    }

    /**
     * 取消点赞
     * @param  Post   $post 依赖注入的文章模型实例
     * @return Response       [description]
     */
    public function unlike(Post $post)
    {
    	//找到点赞记录 删除之
    	$post->like(Auth::id())->delete();
    	return back();
    }
}
