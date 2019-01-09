<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 通过php artisan make:migration alter_tablename_table --table=tablename
         * 新建迁移文件 修改表结构
         * 再php artisan migrate执行文件
         */
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default('/image/default.jpg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
