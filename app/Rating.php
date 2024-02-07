<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'rate',
        'max_rate',
        'rateGivenBy',
    ];

    //user
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
