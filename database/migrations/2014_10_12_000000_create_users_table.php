<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    /**
     * 执行该迁移文件时，可能出现的错误:
     * SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long;
     * max key length is 767 bytes
     *
     * 解析：出现该错误的原因是laravel设置string的长度是1071bytes 
     * 但现今使用的数据库string的最大长度是767bytes
     *
     * 解决办法1：
     * 在 AppServiceProvider 中调用 Schema::defaultStringLength 方法来配置默认字符长度
     *
     * 解决办法2：
     * 修改config/database.php的数据库字符集
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
