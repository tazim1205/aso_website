<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceBid extends Model
{
   
    public function service(){
        return $this->belongsTo(PageService::class,'worker_service_id','id');
    }

    public function customer(){
        return $this->belongsTo(User::class,'customer_id','id');
    }

}
