<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTopics extends Model
{
	/**
	 * 与模型关联的数据表
	 * @var string
	 */
    protected $table = "post_topics";

    /**
     * 主键
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 可以被批量赋值的属性
     * @var array
     */
    protected $fillable = ['post_id','topic_id'];
}
