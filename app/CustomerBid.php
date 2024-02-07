<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerBid extends Model
{
    protected $fillable = [
        'worker_gig_id',
        'customer_id',
        'status',
        'budget',
        'date',
        'time',
        'description',
        'address',
        'image',
    ];

    //Customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id', 'id');
    }

    //workerGig
    public function workerGig()
    {
        return $this->belongsTo(WorkerGig::class, 'worker_gig_id', 'id');
    }

    //cancelInfo
    public function cancelInfo()
    {
        return $this->hasOne(CancelJob::class, 'job_id', 'id')->where('type', 'customer-bid');
    }

    //scope district_id filter query
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
