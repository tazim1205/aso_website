<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    //Get user
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
