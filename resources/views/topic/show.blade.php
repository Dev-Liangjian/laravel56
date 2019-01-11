@extends("layout.main")


@section("content")
<div class="col-sm-8">
    <blockquote>
        <p>{{$topic->name}}</p>
        <footer>文章数：{{$topic->post_topics_count}}</footer>
        <button class="btn btn-default topic-submit"  data-toggle="modal" data-target="#topic_submit_modal" 
        	topic-id="{{$topic->id}}" _token="{{csrf_token()}}" type="button">投稿</button>
    </blockquote>
</div>

<!-- 投稿弹出层 -->
<div class="modal fade" id="topic_submit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    	
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">未投稿的文章</h4>
            </div>

            <div class="modal-body">
                <form action="/topic/{{$topic->id}}/submit" method="post">
                	@foreach($UnsubmittedPost as $post)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="post_ids[]" value="{{$post->id}}">
                            {{$post->title}}
                        </label>
                    </div>
                    @endforeach
                    <button type="submit" class="btn btn-default">投稿</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-8 blog-main">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">文章</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
            	@foreach($posts as $post)
        		<div class="blog-post" style="margin-top: 30px">
                    <p>
                    	<a href="/user/{{$post->user->id}}">{{$post->user->name}}</a> 
                    	{{$post->created_at->toFormattedDateString()}}
                    </p>
                    <p><a href="/posts/{{$post->id}}">{{$post->title}}</a></p>
                    <p>{{$post->content}}</p>
                </div>
                @endforeach
            </div>
		</div>
    
    </div>
</div><!-- /.blog-main -->
@endsection