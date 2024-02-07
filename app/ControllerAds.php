<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControllerAds extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'controller_id',
        'url',
        'image',
        'starting',
        'ending',
        'status',
    ];

    //Controller
    public function controller(){
        return $this->belongsTo(User::class,'controller_id','id');
    }

    public function scopeActive($query){
        return $query->where('status',1);
    }

    public function scopeInactive($query){
        return $query->where('status',0);
    }
}
