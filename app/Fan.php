<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fan extends Model
{
	/**
	 * 与模型关联的数据表
	 * @var string
	 */
    protected $table = "fans";

    /**
     * 主键
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * 可以被批量赋值的属性
     * @var array
     */
    protected $fillable = ['fan_id','star_id'];
}
