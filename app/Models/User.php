<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
