<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherExpense extends Model
{
    protected  $fillable =[
        'date',
        'month',
        'amount',
        'details',
        'user_id',
    ];

    public function scopeTotal($query)
    {
        return $query->sum('amount');
    }

    //scope month filter query
    public function scopeMonth($query, $month)
    {
        if ($month && $month != 'All') {
            return $query->where('month', $month);
        }
        return $query;
    }

    //scope year filter query
    public function scopeYear($query, $year)
    {
        if ($year && $year != 'All') {
            return $query->whereYear('date', $year);
        }
        return $query;
    }
}
