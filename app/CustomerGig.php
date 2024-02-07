<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerGig extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'address',
        'service_id',
        'day',
        'date',
        'time',
        'budget',
        'status',
    ];

    //Customer
    public function customer(){
        return $this->belongsTo(User::class,'customer_id','id');
    }


    public function service(){
        return $this->belongsTo(WorkerService::class,'service_id','id');
    }


    //cancelInfo
    public function cancelInfo(){
        return $this->hasOne(CancelJob::class,'job_id','id')->where('type', 'bid');
    }

    //workerBids
    public function workerBids(){
        return $this->hasMany(WorkerBid::class,'customer_gig_id','id');
    }

    public function worker(){
        return $this->belongsTo(User::class,'worker_id','id');
    }
}
