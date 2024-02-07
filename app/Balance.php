<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'due',
        'referral_income',
        'withdrawn',
        'is_registration_comission',
        'service_change',
    ];

    //user
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
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
}
