<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RattingReview extends Model
{
    //user
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
