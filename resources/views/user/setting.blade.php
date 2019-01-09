@extends("layout.main")

@section("content")
<div class="col-sm-8 blog-main">
    <form class="form-horizontal" onSubmit="return check();"
        action="/user/me/setting" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                {{Auth::user()->name}}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">头像</label>
            <div class="col-sm-2">
                <input class="file-loading preview_input" onchange="imgPreview(this)"
                    id="input_file" type="file" style="width:72px" name="avatar">
                <img id="preview_img" src="{{asset('storage/'.Auth::user()->avatar)}}" 
                    alt="" class="img-rounded" style="border-radius:500px;">
            </div>
        </div>
        <button type="submit" class="btn btn-default">修改</button>
    </form>
    <br>
</div>
@endsection

@section("modifyAvatar")
<script type="text/javascript" src="/js/modifyAvatar.js"></script>
@endsection