<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Fan;

class User extends Authenticatable
{
	/**
	 * 与模型关联的数据表
	 * @var string
	 */
    protected $table = "users";

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
    protected $fillable = ['name','email','password'];

    /**
     * 不可被批量赋值的属性
     * @var [type]
     */
    // protected $guarded ;
    

    /**
     * 获得此用户的文章
     */
    public function posts()
    {
        return $this->hasMany(\App\Post::class,'user_id','id');
    }

    /**
     * 获得此用户的粉丝
     */
    public function fans()
    {
        return $this->hasMany(\App\Fan::class,'star_id','id');
    }

    /**
     * 获得此用户关注的用户
     */
    public function stars()
    {
        return $this->hasMany(\App\Fan::class,'fan_id','id');
    }

    /**
     * 判断该用户是否存在$uid的粉丝
     * @param  integer  $uid 用户ID
     * @return boolean       存在返回true 否则返回false
     */
    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id','=',$uid)->exists();
    }

    /**
     * 判断该用户是否关注$uid用户
     * @param  integer  $uid 用户ID
     * @return boolean       已关注返回true 否则返回false
     */
    public function hasStar($uid)
    {
        return $this->stars()->where('star_id','=',$uid)->exists();
    }
}