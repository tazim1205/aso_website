<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    //
    protected $fillable = [
        'user_id',
        'own',
        'by',
    ];

    //User
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
