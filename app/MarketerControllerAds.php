<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketerControllerAds extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'controller_id',
        'url',
        'image',
        'starting',
        'ending',
        'status',
        'title',
        'description',
    ];

    //Controller
    public function controller(){
        return $this->belongsTo(User::class,'controller_id','id');
    }
}
