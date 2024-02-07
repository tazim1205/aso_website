<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'user_id',
        'membership_package_id',
        'duration',
        'ending_at',
        'status',
        'sub_categories',
        'payment_status',
        'amount',
    ];

    //Membership Type User
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    //Membership Package
    public function membershipPackage(){
        return $this->belongsTo(MembershipPackage::class,'membership_package_id','id');
    }

    public function scopeFirstTime($query){
        return $query->where('status','first_time');
    }

    public function scopeRenew($query){
        return $query->where('status','renew');
    }

    public function scopeUpgraded($query){
        return $query->where('status','upgrade');
    }

    //scope district_id filter query
    public function scopeDistrict($query, $district_id)
    {
        if ($district_id && $district_id != 'All') {
            return $query->whereHas('user', function ($query) use ($district_id) {
                $query->where('district_id', $district_id);
            });
        }
        return $query;
    }

    //scope upazila_id filter query
    public function scopeUpazila($query, $upazila_id)
    {
        if ($upazila_id && $upazila_id != 'All') {
            return $query->whereHas('user', function ($query) use ($upazila_id) {
                $query->where('upazila_id', $upazila_id);
            });
        }
        return $query;
    }

    //scope month filter query
    public function scopeMonth($query, $month)
    {
        if ($month && $month != 'All') {
            return $query->whereMonth('created_at', $month);
        }
        return $query;
    }

    //scope year filter query
    public function scopeYear($query, $year)
    {
        if ($year && $year != 'All') {
            return $query->whereYear('created_at', $year);
        }
        return $query;
    }

    //scope group user_id and sum amount
    public function scopeGrouyByUser($query)
    {
        return $query->selectRaw('user_id, sum(amount) as total_paid')
            ->groupBy('user_id');
    }

    public function scopeSameAreaUser($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('district_id', auth()->user()->district_id)
                ->where('upazila_id', auth()->user()->upazila_id);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('ending_at', null);
    }
}
