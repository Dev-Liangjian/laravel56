<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	/**
	 * 与模型关联的数据表
	 * @var string
	 */
    protected $table = "topics";

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
    protected $fillable = ['name'];

    /**
     * 关联 App\Post 模型
     * 获得拥有此标签的文章
     * @return [type] [description]
     */
    public function posts()
    {
    	/**
    	 * 第一个参数是要关联的模型
    	 * 第二个参数是关联连接表表名
    	 * 第三个参数是定义此关联的模型在连接表里的外键名
    	 * 第四个参数是另一个模型在连接表里的外键名
    	 */
    	return $this->belongsToMany(\App\Post::class,'post_topics','topic_id','post_id');
    }

    /**
     * 关联 App\PostTopics 模型
     * 获得拥有该标签的文章数 用于withCount时添加的字段是post_topics_count
     * 这个方法不太规范
     * @return [type] [description]
     */
    public function postTopics()
    {
    	return $this->hasMany(\App\PostTopics::class,'topic_id','id');
    }
}
