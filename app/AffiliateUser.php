<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateUser extends Model
{
    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function affiliate_payments()
    {
      return $this->hasMany(AffiliatePayment::class)->orderBy('created_at', 'desc')->paginate(12);
    }

    public function scopeTotal($query)
    {
      return $query->count();
    }

    public function scopeDistrict($query, $district)
    {
      if($district && $district != 'All'){
        return $query->whereHas('user', function ($query) use ($district) {
          $query->where('district_id', $district);
        });
      }
      return $query;
    }

    public function scopeUpazila($query, $upazila)
    {
      if($upazila && $upazila != 'All'){
        return $query->whereHas('user', function ($query) use ($upazila) {
          $query->where('upazila_id', $upazila);
        });
      }
    }

    public function scopeMonth($query, $month)
    {
      if($month && $month != 'All'){
        return $query->whereMonth('created_at', $month);
      }
    }

    public function scopeYear($query, $year)
    {
      if($year && $year != 'All'){
        return $query->whereYear('created_at', $year);
      }
    }
}
