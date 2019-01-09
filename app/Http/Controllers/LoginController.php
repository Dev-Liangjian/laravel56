<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * 返回登陆页面
     * @return view 带有登陆表单的页面
     */
    public function index()
    {
    	return view('login.index');
    }

    /**
     * 验证登陆
     * @param  Request $request 登陆请求
     * @return Response 登陆成功跳转至首页 登陆失败跳转到登陆页           
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:16',
            'is_remember' => 'integer',
        ]);
        $user = $request->only(['email','password']);
        $is_remember = boolval($request->input('is_remember'));

        if( Auth::attempt($user,$is_remember) ){
            return redirect('/posts');
        }   
    
        // 使用 withErrors 方法把错误消息闪存到 Session
        return back()->withErrors("邮箱密码不匹配");
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
