<div>
	@if( \Auth::user()->hasStar($target_user->id) )
	<!-- follow-status == 1 表示已关注 -->
	<button class="btn btn-default follow-button" follow-status="1" 
		follow-user="{{$target_user->id}}"  type="button">取消关注</button>
	@else
	<button class="btn btn-default follow-button" follow-status="0" 
		style="background-color: #337ab7; color: #fff;" 
		follow-user="{{$target_user->id}}"  type="button">关注</button>
	@endif
</div>