<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Fan;


class UserController extends Controller
{
    public function setting()
    {
    	return view('user.setting');
    }

    public function settingStore(Request $request)
    {
    	if( $request->hasFile('avatar') ){
    		$avatar = $request->file('avatar');
    		if( $avatar->isValid() && in_array($avatar->extension(), ['jpg', 'jpeg', 'bmp', 'png']) ){
    			$path = $avatar->store('images', 'public');
    			Auth::user()->avatar = $path;
    			Auth::user()->save();
    			//return ['errno' => 0, 'msg' => asset('storage/'.$path)];
    			return redirect("/user/me/setting");
    		}else{
    			return ['errno' => 1, 'msg' => 'Not a valid image'];
    		}
    	}
    	return ['errno' => 1, 'msg' => 'No file uploaded'];
    }

    public function show(User $user)
    {
    	//在结果集模型中添加文章数 粉丝数 关注数
    	$user = User::withCount(['posts','fans','stars'])->find($user->id);

    	//文章列表
    	$posts = $user->posts()->orderBy('created_at','desc')->get();

    	//粉丝列表
    	$fans = $user->fans;
    	//根据fan_id在User模型中检索出所有粉丝用户
    	$fanUsers = User::whereIn('id',$fans->pluck('fan_id'))
    				->withCount(['posts','fans','stars'])->get();

    	//关注列表
    	$stars = $user->stars;
    	$starUsers = User::whereIn('id',$stars->pluck('star_id'))
    				->withCount(['posts','fans','stars'])->get();

    	return view('user/show',compact('user','posts','fanUsers','starUsers'));
    }

    //关注
    public function follow(User $user)
    {
    	$fan = new Fan();
    	$fan->star_id = $user->id;
    	$fan->fan_id = Auth::id();
    	$fan->save();

    	return ['error' => 0 , 'msg' => 'OK'];
    }

    //取消关注
    public function unfollow(User $user)
    {
    	Fan::where([
    		['star_id','=',$user->id],
    		['fan_id','=',Auth::id()],
    	])->delete();
    	return ['error' => 0 , 'msg' => 'OK'];
    }
}
