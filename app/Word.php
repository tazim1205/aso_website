<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    
     //pouroshobha
     public function pouroshobha(){
        return $this->belongsTo(Puroshova::class,'puroshova_id','id');
    }

    public function customer(){
        return $this->hasMany(User::class,'word_road_id','id')->where('role','customer');
    }

    public function worker(){
        return $this->hasMany(User::class,'word_road_id','id')->where('role','worker');
    }

    public function marketer(){
        return $this->hasMany(User::class,'word_road_id','id')->where('role','marketer');
    }

    public function membership(){
        return $this->hasMany(User::class,'word_road_id','id')->where('role','membership');
    }
}

