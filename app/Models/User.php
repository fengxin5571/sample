<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    const DEFAUT_SEX=0;
    const MALE_SEX=1;
    const FEMALE_SEX=2;
    /*
     * 表名
     */
    protected $table="users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','sex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /*
     * 模型完成初始化后，进行加载
     */
    public static function boot(){
        parent::boot();
        static::creating(function ($user){//模型创建之前的事件
            $user->activation_token =str_random(30);
        });
    }
    //用户头像方法
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
    //用户性别
    public function getSex($key=null){
        $sexs=[
            self::DEFAUT_SEX=>'保密',
            self::MALE_SEX=>'男',
            self::FEMALE_SEX=>'女'
        ];
        if($key!=null){
            return array_key_exists($key, $sexs)?$sexs[$key]:$sexs[self::DEFAUT_SEX];
        }
        return $sexs;
    }
    /*
     * 微博模型关联一对多
     */
    public function statuses(){
        return $this->hasMany(Status::class);
    }
    /*
     * 粉丝多对多
     */
    public function followers(){
        return $this->belongsToMany(User::class,"followers","user_id","follower_id");
    }
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }
    public function feed(){
        $user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids, Auth::user()->id);
        return Status::whereIn("user_id",$user_ids)->orderBy("created_at","desc");
    }
    /*
     * 判断是否被关注
     */
    public function isFollowing($user_id){
        return $this->followings()->get()->contains($user_id);
    }
    /*
     * 关注
     */
    public function follow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids,false);
    }
    /*取消关注*/
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }
    
}
