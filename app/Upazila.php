<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upazila extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'district_id',
    ];

    //District
    public function district(){
        return $this->belongsTo(District::class,'district_id','id');
    }

    // Pouroshova
    public function pouroshova()
    {
        return $this->hasMany(Puroshova::class, 'upazila_id', 'id')->orderBy('id', 'desc');
    }

    //Users
    public function users(){
        return $this->hasMany(User::class,'upazila_id','id')->orderBy('id','desc');
    }

    //controllers
    public function controllers(){
        return $this->hasMany(User::class,'upazila_id','id')->where('role','controller')->orderBy('id','desc');
    }

    public function helplines(){
        return $this->hasMany(CustomerWorkerHelplines::class,'upazila_id','id')->where('worker_or_customer','Worker')->orderBy('id','desc');
    }

    //Customers
    public function customers(){
        return $this->hasMany(User::class,'upazila_id','id')->where('role','customer')->orderBy('id','desc');
    }

    //Workers
    public function workers(){
        return $this->hasMany(User::class,'upazila_id','id')->where('role','worker')->orderBy('id','desc');
    }

    //Marketer
    public function marketers(){
        return $this->hasMany(User::class,'upazila_id','id')->where('role','marketer')->orderBy('id','desc');
    }

    //Membership
    public function memberships(){
        return $this->hasMany(User::class,'upazila_id','id')->where('role','membership')->orderBy('id','desc');
    }

    //Special profile
    public function special_profiles(){
        return $this->hasMany(SpecialProfile::class,'upazila_id','id');
    }
    //membership service profile
    public function membership_service_profiles(){
        return $this->hasMany(MembershipServiceProfile::class,'upazila_id','id');
    }




}
