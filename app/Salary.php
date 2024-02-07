<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'date',
        'month',
        'amount',
        'note',
        'category',
    ];

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

    public function scopeCategory($query, $category)
    {
        if($category && $category != 'All'){
            return $query->where('category', $category);
        }
        return $query;
    }

    //scope total query
    public function scopeTotal($query)
    {
        return $query->sum('amount');
    }

    public function scopeManagerTotal($query)
    {
        return $query->where('category', 'manager')->sum('amount');
    }

    public function scopeAccountantTotal($query)
    {
        return $query->where('category', 'accountant')->sum('amount');
    }

    public function scopeDirectorTotal($query)
    {
        return $query->where('category', 'director')->sum('amount');
    }

    public function scopeMarketingManagerTotal($query)
    {
        return $query->where('category', 'marketing_manager')->sum('amount');
    }

    public function scopeMarketingPanelControllerTotal($query)
    {
        return $query->where('category', 'marketing_panel_controller')->sum('amount');
    }

    //others
    public function scopeOthersTotal($query)
    {
        return $query->where('category', 'others')->sum('amount');
    }
}
