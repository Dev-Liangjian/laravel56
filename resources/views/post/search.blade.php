@extends("layout.main")

@section("content")
<div class="alert alert-success" role="alert">
    为您找到相关结果约{{$posts->total()}}个
</div>

<div class="col-sm-8 blog-main">
    @foreach($posts as $post)
    <div class="blog-post">
        <h2 class="blog-post-title">
            <a href="/posts/{{$post->id}}" >
                {{ $post->title }}
            </a>
        </h2>
        <p class="blog-post-meta">{{ $post->created_at->toFormattedDateString() }} 
                by <a href="#">{{ $post->user->name }}</a>
        </p>
        {!! $post->content !!}
    </div>
    @endforeach

    {{$posts->links()}}
</div>
@endsection