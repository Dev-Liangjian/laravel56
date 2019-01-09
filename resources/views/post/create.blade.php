@extends("layout.main")

@section("content")
<div class="col-sm-8 blog-main">
    @include("layout.error")
    <form action="/posts" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <label>标题</label>
            <input name="title" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label>内容</label>
            <input type="hidden" id="content" name="content">
            <div id="editor">
                
            </div>
        </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>
</div>
@endsection

@section("wangEditor")
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/wangEditor.js"></script>
<script type="text/javascript" src="/js/createWangEditor.js"></script>
@endsection