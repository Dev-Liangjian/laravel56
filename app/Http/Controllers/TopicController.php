<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
    	//带文章数的专题
    	$topic = Topic::withCount('postTopics')->find($topic->id);

    	//专题的文章列表
    	$posts = $topic->posts()->orderBy('created_at','desc')->get();

    	//我的未投稿文章
    	$UnsubmittedPost = \App\Post::CreateBy(\Auth::id())
    						->UnTopicBy($topic->id)->get();

    	return view('topic.show',compact('topic','posts','UnsubmittedPost'));
    }

    public function submit()
    {
    	return ;
    }
}
