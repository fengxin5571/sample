<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use Notifiable;
    /*
     * 表名
     */
    protected $table="admins";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_name', 'admin_email', 'admin_password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'admin_password', 'remember_token',
    ];
    public function getAuthPassword(){
        return $this->admin_password;
    }
    //用户头像方法
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['admin_email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
