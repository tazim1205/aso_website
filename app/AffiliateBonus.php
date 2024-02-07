<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateBonus extends Model
{
    public function affiliate_user()
    {
        return $this->belongsTo(User::class, 'affiliate_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //scope same area user
    public function scopeSameAreaUser($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('district_id', auth()->user()->district_id)
                ->where('upazila_id', auth()->user()->upazila_id);
        });
    }

    public function workerGig()
    {
        return $this->belongsTo(WorkerGig::class);
    }

    public function workerBid()
    {
        return $this->belongsTo(WorkerBid::class);
    }

    public function customerGig()
    {
        return $this->belongsTo(CustomerGig::class);
    }

    public function customerBid()
    {
        return $this->belongsTo(CustomerBid::class);
    }

    public function scopeTotal($query)
    {
        return $query->count();
    }

    public function scopeDistrict($query, $district)
    {
        if ($district && $district != 'All') {
            return $query->whereHas('affiliate_user', function ($query) use ($district) {
                $query->where('district_id', $district);
            });
        }
        return $query;
    }

    public function scopeUpazila($query, $upazila)
    {
        if ($upazila && $upazila != 'All') {
            return $query->whereHas('affiliate_user', function ($query) use ($upazila) {
                $query->where('upazila_id', $upazila);
            });
        }
    }

    public function scopeMonth($query, $month)
    {
        if ($month && $month != 'All') {
            return $query->whereMonth('created_at', $month);
        }
    }

    public function scopeYear($query, $year)
    {
        if ($year && $year != 'All') {
            return $query->whereYear('created_at', $year);
        }
    }

    //scope worker gig worker area equal controller area and sum amount
    public function scopeWorkerGig($query)
    {
        return $query->whereHas('workerGig', function ($query) {
            $query->whereHas('worker', function ($query) {
                $query->where('district_id', auth()->user()->district_id)
                    ->where('upazila_id', auth()->user()->upazila_id);
            });
        });
    }

    public function scopeWorkerBid($query)
    {
        return $query->whereHas('workerBid', function ($query) {
            $query->whereHas('worker', function ($query) {
                $query->where('district_id', auth()->user()->district_id)
                    ->where('upazila_id', auth()->user()->upazila_id);
            });
        });
    }

    public function scopeCustomerGig($query)
    {
        return $query->whereHas('customerGig', function ($query) {
            $query->whereHas('customer', function ($query) {
                $query->where('district_id', auth()->user()->district_id)
                    ->where('upazila_id', auth()->user()->upazila_id);
            });
        });
    }

    public function scopeCustomerBid($query)
    {
        return $query->whereHas('customerBid', function ($query) {
            $query->whereHas('customer', function ($query) {
                $query->where('district_id', auth()->user()->district_id)
                    ->where('upazila_id', auth()->user()->upazila_id);
            });
        });
    }


}
