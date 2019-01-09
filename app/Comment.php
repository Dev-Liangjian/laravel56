<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	/**
	 * 与模型关联的数据表
	 * @var string
	 */
    protected $table = "comments";

    /**
     * 主键
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * 关联App\Post模型  获得评论所属的文章
     * @return [type] [description]
     */
    public function post()
    {
    	return $this->belongsTo('App\Post','post_id','id');
    }

    /**
     * 关联App\User模型  获得评论的属主
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
}
