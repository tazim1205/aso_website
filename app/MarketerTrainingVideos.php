<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketerTrainingVideos extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'video_for',
        'controller_id',
        'district_id',
        'upazila_id',
        'link',
        'title',
        'status',
    ];

    //Controller
    public function controller(){
        return $this->belongsTo(User::class,'controller_id','id');
    }

    public function district(){
        return $this->belongsTo(District::class,'district_id','id');
    }

    public function upazila(){
        return $this->belongsTo(Upazila::class,'upazila_id','id');
    }
}
