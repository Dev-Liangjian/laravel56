<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
	/**
	 * 与模型关联的数据表
	 * @var string
	 */
    protected $table = "likes";

    /**
     * 主键
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * 可以被批量赋值的属性
     * @var array
     */
    protected $fillable = ['user_id','post_id'];
}
