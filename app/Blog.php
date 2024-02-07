<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    
    //Category
    public function category(){
        return $this->belongsTo(WorkerServiceCategory::class,'category_id','id');
    }

    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
