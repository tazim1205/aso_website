<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembershipServiceProfile extends Model
{
    protected $fillable = [
        'member_id',
        'membership_id',
        'membership_service_id',
        'logo',
        'name',
        'mobile',
        'title',
        'description',
        'address',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'image6',
        'image7',
        'image9',
        'image10',
        'image11',
        'image12',
        'image13',
        'image14',
        'image15',
        'position',
        'upazila_id',
    ];

    //user
    public function user(){
        return $this->belongsTo(User::class,'member_id','id');
    }

    //upazila
    public function upazila(){
        return $this->belongsTo(Upazila::class,'upazila_id','id');
    }
}
