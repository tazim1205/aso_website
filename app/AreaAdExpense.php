<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AreaAdExpense extends Model
{
    protected $fillable = ['exp_date', 'amount', 'details', 'user_id', 'district_id', 'upazila_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }

    public function scopeSameAreaUser($query)
    {
        return $query->where('district_id', auth()->user()->district_id)
                ->where('upazila_id', auth()->user()->upazila_id);
    }

    public function scopeDistrict($query, $district_id)
    {
        if ($district_id && $district_id != 'All') {
            return $query->where('district_id', $district_id);         
        }
        return $query;
    }

    //scope upazila_id filter query
    public function scopeUpazila($query, $upazila_id)
    {
        if ($upazila_id && $upazila_id != 'All') {
            return $query->where('upazila_id', $upazila_id);
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
