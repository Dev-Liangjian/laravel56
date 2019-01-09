/*
* @Author: Dev-Liangjian
* @Date:   2019-01-08 15:04:35
* @Last Modified by:   Dev-Liangjian
* @Last Modified time: 2019-01-08 18:07:19
*/
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$('.follow-button').click(function(event){
	var target = $(event.target);
	var user_id = target.attr('follow-user');

	if( target.attr('follow-status') == 1){
		//取消关注
		$.ajax({
			url: "/user/" + user_id + "/unfollow",
			method: "post",
			dataType: "json",
			success: function (data){
				if(data.error != 0){
					alert(data.msg);
					return ;
				}
				window.location.reload();
			}
		})
	}else{
		$.ajax({
			url: "/user/" + user_id + "/follow",
			method: "post",
			dataType: "json",
			success: function (data){
				if(data.error != 0){
					alert(data.msg);
					return ;
				}
				window.location.reload();
			}
		})
	}
});