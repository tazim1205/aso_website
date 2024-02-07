<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembershipAndService extends Model
{
    protected $fillable = [
        'membership_id',
        'service_id',
    ];

    //Membership
    public function membership(){
        return $this->belongsTo(User::class,'membership_id','id');
    }

    //Service
    public function service(){
        return $this->belongsTo(MembershipService::class,'service_id','id');
    }
}
