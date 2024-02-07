<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelJob extends Model
{
    protected $fillable = [
        'type',
        'job_id',
        'canceller_id',
    ];

    //Job
    public function job(){
        return $this->belongsTo(Job::class,'job_id','id');
    }

    //Canceller
    public function canceller(){
        return $this->belongsTo(User::class,'canceller_id','id');
    }

}
