<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'content'
    ];
    
    //模型关联一对多的反向
    public function user(){
        return $this->belongsTo(User::class);
    }
}
