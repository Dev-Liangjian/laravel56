<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    /**
     * 注册请求响应
     * @return view 带注册表单的页面
     */
    public function index()
    {
    	return view('register.index');
    }

    /**
     * 注册逻辑
     * @param  Request $request 注册请求
     * @return view           重定向至登陆页面
     */
    public function register(Request $request)
    {
    	//验证
	    $validatedData = $request->validate([
	    	'name' => 'required|min:5|unique:users,name',
	    	'email' => 'required|email|unique:users,email',
	    	'password' => 'required|min:6|max:16|confirmed',
	    ]);
    	//业务处理逻辑
    	$name = $request->input('name');
    	$email = $request->input('email');
    	$password = bcrypt($request->input('password'));
    	$user = User::create(compact('name','email','password'));

    	//响应(渲染)
    	return redirect('/login');
    }
}
