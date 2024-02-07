<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nid extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'front_image',
        'back_image',
        'isVerified',
    ];

    //Worker
    public function worker(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    //Membership
    public function membership(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
