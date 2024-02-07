<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OthersIncome extends Model
{
    protected $fillable = ['date', 'amount', 'description'];

    public function scopeTotal($query)
    {
        return $query->sum('amount');
    }

    public function scopeMonth($query, $month)
    {
        if ($month !== 'All') {
            $query->whereMonth('date', $month);
        }

        return $query;
    }

    public function scopeYear($query, $year)
    {
        if ($year !== 'All') {
            $query->whereYear('date', $year);
        }

        return $query;
    }
}
