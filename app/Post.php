<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder as Builder;
//表 => posts
class Post extends Model
{
    use Searchable; //这个 trait 会注册一个模型观察者来保持模型和搜索驱动的同步

    //配置模型索引    在elasticsearch中作为type检索该模型
    public function searchableAs()
    {
        return "post";
    }

    //配置可搜索数据
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
	/**
	 * 与模型关联的数据表
	 * @var string
	 */
    protected $table = "posts";

    /**
     * 主键
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * 可以被批量赋值的属性
     * @var array
     */
    protected $fillable = ['title','content','user_id'];

    /**
     * 不可被批量赋值的属性
     * @var [type]
     */
    // protected $guarded ;
    

    /**
     * 关联App\User 用户模型  
     * 获得此文章的属主
     * 定义反向关联之后可以通过 Post::find(1)->user 取得关联的User对象
     * @return [type] [description]
     */
    public function user()
    {
        /**
         * belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
         * $related 关联模型的类名
         * $foreginKey 关联模型的外键
         * $ownerKey 父级模型(App\User)通过$ownerKey字段连接子级模型(App\Post) 
         */
        return $this->belongsTo('App\User','user_id','id');
    }

    /**
     * 关联 App\Comment 评论模型 
     * 获得此文章的所有评论
     * @return [type] [description]
     */
    public function comments()
    {
        /**
         * hasMany($related, $foreignKey = null, $localKey = null)
         * $related 关联模型的类名(App\Comment)
         * $foreignKey  关联模型上正确的外键字段
         * $localKey 与父级模型(App\Post)id 列的值相匹配的值
         * 换句话说,Eloquent 将会在 Comment 记录的 $foreignKey（即post_id） 列中查找与文章表的 $localKey（即id） 列相匹配的值
         */
        // return $this->hasMany('App\Comment','post_id','id');
        return $this->hasMany('App\Comment','post_id','id')->orderBy('created_at','desc');
    }

    /**
     * 关联 App\Like 赞模型 
     * 获取文章的所有赞
     * @return [type] [description]
     */
    public function likes()
    {
        return $this->hasMany('App\Like','post_id','id');
    }

    /**
     * App\Post和App\User 一起关联 App\Like 赞模型
     * 获得某个用户对某篇文章的赞    
     * @param  integer $user_id 用户模型主键
     * @return Illuminate\Database\Eloquent\Relations\HasMany          [description]
     */
    public function like($user_id)
    {
        return $this->hasMany('App\Like','post_id','id')->where('user_id','=',$user_id);
    }

    /**
     * 利用scope方法实现获取[属于某用户]的文章
     * @param  Builder $query    [description]
     * @param  integer  $user_id [description]
     * @return Builder           [description]
     */
    public function scopeCreateBy(Builder $query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);
    }

    /**
     * 关联 App\PostTopics 模型
     * 获取当前文章的所有标签
     * @return [type] [description]
     */
    public function postTopics()
    {
        return $this->hasMany(\App\PostTopics::class,'post_id','id');
    }

    /**
     * 利用scope方法实现获取[不拥有某标签]的所有文章
     * @param  Builder $query     [description]
     * @param  integer  $topic_id [description]
     * @return Builder            [description]
     */
    public function scopeUnTopicBy(Builder $query, $topic_id)
    {
        //(利用基于不存在的关联查询doesntHave)获得不拥有任何标签的文章
        // return $query->doesntHave('postTopics');
        
        //在不拥有任何标签的文章 的基础上对标签进行检查(排除某个特殊的标签)
        return $query->whereDoesntHave('postTopics', function($q) use($topic_id){
            $q->where('topic_id','=',$topic_id);
        });
    }
}