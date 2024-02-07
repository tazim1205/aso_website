<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialServiceOrder extends Model
{
    protected $guarded =  [];

    /**
     * Get the customer that owns the SpecialServiceOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    /**
     * Get the service that owns the SpecialServiceOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(WorkerService::class, 'service_id', 'id');
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

    //scope group by customer count total and total fee
    public function scopeGroupByCustomer($query)
    {
        return $query->selectRaw('customer_id, count(*) as total, sum(fee) as total_fee')
            ->groupBy('customer_id');
    }

    public function scopeSameAreaUser($query)
    {
        return $query->whereHas('customer', function ($query) {
            $query->where('district_id', auth()->user()->district_id)
                ->where('upazila_id', auth()->user()->upazila_id);
        });
    }
}
