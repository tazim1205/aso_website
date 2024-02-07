<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerGig extends Model
{
    protected $fillable = [
        'worker_id',
        'service_id',
        'title',
        'description',
        'tags',
        'budget',
        'day',
        'cover_photo',
        'thambline_photo',
        'income',
        'service_charge',
    ];

    //Worker
    public function worker(){
        return $this->belongsTo(User::class,'worker_id','id');
    }

    //Service
    public function service(){
        return $this->belongsTo(WorkerService::class,'service_id','id');
    }

    //customerBids
    public function customerBids(){
        return $this->hasMany(CustomerBid::class,'worker_gig_id','id');
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

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisabled($query)
    {
        return $query->where('status', 'disabled');
    }

    public function scopeServiceId($query, $service_id){
        if($service_id){
            return $query->where('service_id', $service_id);
        }

        return $query;
    }
}
