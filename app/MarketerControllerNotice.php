<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketerControllerNotice extends Model
{
    protected $fillable = [
        'controller_id',
        'title',
        'detail',
    ];

    //Controller
    public function controller(){
        return $this->belongsTo(User::class,'controller_id','id');
    }
}
