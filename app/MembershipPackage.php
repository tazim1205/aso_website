<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipPackage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'three_month_price',
        'six_month_price',
        'twelve_month_price',
        'mobile_availability',
        'description_availability',
        'image_count',
        'position',
    ];

    //Membership Type User
    public function membership(){
        return $this->hasMany(Membership::class,'membership_package_id','id');
    }
}
