<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'transaction_id', 'status', 'payment_method', 'payment_gateway', 'payment_date', 'payment_time'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeTotalRecharge($query)
    {
        return $query->where('status', 'success')->sum('amount');
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
