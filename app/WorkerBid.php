<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerBid extends Model
{
    protected $fillable = [
        'customer_gig_id',
        'worker_id',
        'budget',
        'proposed_budget',
        'description',
        'is_selected',
        'is_cancelled',
        'income',
        'service_charge'
    ];

    //Job
    public function customerGig(){
        return $this->belongsTo(CustomerGig::class,'customer_gig_id','id');
    }

    //Customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id', 'id');
    }

    public function scopeTotalIncome($query)
    {
        return $query->sum('income');
    }

    //scope district_id filter query
    public function scopeDistrict($query, $district_id)
    {
        if ($district_id && $district_id != 'All') {
            return $query->whereHas('worker', function ($query) use ($district_id) {
                $query->where('district_id', $district_id);
            });
        }
        return $query;
    }

    //scope upazila_id filter query
    public function scopeUpazila($query, $upazila_id)
    {
        if ($upazila_id && $upazila_id != 'All') {
            return $query->whereHas('worker', function ($query) use ($upazila_id) {
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

    public function scopeSameAreaUser($query)
    {
        return $query->whereHas('worker', function ($query) {
            $query->where('district_id', auth()->user()->district_id)
                ->where('upazila_id', auth()->user()->upazila_id);
        });
    }

    public function scopeGroupByArea($query)
    {
        return $query->whereHas('worker', function ($query) {
            $query->where('district_id', auth()->user()->district_id)
                ->where('upazila_id', auth()->user()->upazila_id)
                ->groupBy('upazila_id');
        });
    }
}
