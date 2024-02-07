<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdExpense extends Model
{
    protected $fillable = ['exp_date', 'amount', 'details', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
