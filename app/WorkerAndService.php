<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerAndService extends Model
{
    protected $fillable = [
        'worker_id',
        'service_id',
    ];

    //Worker
    public function worker(){
        return $this->belongsTo(User::class,'worker_id','id');
    }

    //Service
    public function service(){
        return $this->belongsTo(WorkerService::class,'service_id','id');
    }
}
