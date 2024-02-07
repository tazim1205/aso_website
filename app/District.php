<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        ];

    //Upazila
    public function upazila(){
        return $this->hasMany(Upazila::class,'district_id','id')->orderBy('id','desc');
    }
}
