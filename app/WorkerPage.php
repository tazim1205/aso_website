<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerPage extends Model
{
    protected $guarded = [];

    //Worker
    public function worker(){
        return $this->belongsTo(User::class,'worker_id','id');
    }

    // Membership
    public function membership()
    {
        return $this->belongsTo(MembershipPackage::class, 'membership_id', 'id');
    }
    
}
