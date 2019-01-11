<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

use App\Libraries\MyEsEngine;
use Laravel\Scout\EngineManager;
use Elasticsearch\ClientBuilder as ElasticBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * 在容器中注册绑定。
     * @return void
     */
    public function boot()
    {
        /**
         * Laravel 默认使用 utf8mb4 字符，它支持在数据库中存储 "emojis" 。 
         * 如果你是在版本低于 5.7.7 的 MySQL release 或者版本低于 10.2.2 的 MariaDB release 上
         * 创建索引，那就需要你手动配置迁移生成的默认字符串长度。 
         * 即在 AppServiceProvider 中调用 Schema::defaultStringLength 方法来配置它
         */
        Schema::defaultStringLength(191); //Solved by increasing String Length

        //视图合成器
        View::composer('layout.sidebar',function($view){
            $topics = \App\Topic::all();
            $view->with('topics', $topics);
        });
    }



    /**
     * Register any application services.
     * 注册服务器提供者。
     * @return void
     */
    public function register()
    {
        //
    }
}
