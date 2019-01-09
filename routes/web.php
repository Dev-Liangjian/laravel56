<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Web路由文件 路由是有先后顺序的，当发生路由冲突时前面的路由先解析

//用户注册
Route::get('/register','RegisterController@index');
Route::post('/register','RegisterController@register');

//用户登录
Route::get('/login','LoginController@index');
Route::post('/login','LoginController@login');
Route::get('/logout','LoginController@logout');

Route::middleware(['checkLogin'])->group(function () {
	//文章列表页
	Route::get('/', 'PostController@index');
	Route::get('/posts','PostController@index')->name('index');
	//文章详情页
	Route::get('/posts/{post}','PostController@show')->where('post','[0-9]+');

	//创建文章
	Route::get('/posts/create','PostController@create')->name("create");
	Route::post('/posts','PostController@store')->name("store");

	//编辑文章
	Route::get('/posts/{post}/edit','PostController@edit');
	Route::put('/posts/{post}','PostController@update');

	//删除文章
	Route::get('/posts/{post}/delete','PostController@delete');

	//评论文章
	Route::post('/posts/{post}/comment','CommentController@comment');

	//点赞
	Route::get('/posts/{post}/like','LikeController@like');
	//取消点赞
	Route::get('/posts/{post}/unlike','LikeController@unlike');
	//个人中心
	Route::get('/user/{user}','UserController@show');
	//个人设置
	Route::get('/user/me/setting','UserController@setting');
	Route::post('/user/me/setting','UserController@settingStore');
	//关注 和 取消关注
	Route::post('/user/{user}/follow','UserController@follow');
	Route::post('/user/{user}/unfollow','UserController@unfollow');
});


//图片上传
Route::post('/posts/image/upload','PostController@imageUpload');

//搜索	此功能需运行ElasticSearch服务
Route::get('/posts/search','PostController@search');