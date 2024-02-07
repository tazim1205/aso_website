<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puroshova extends Model
{
    public function word(){
        return $this->hasMany(Word::class,'puroshova_id','id')->orderBy('name','asc');
    }

    public function customer(){
        return $this->hasMany(User::class,'pouroshova_union_id','id')->where('role','customer');
    }

    public function worker(){
        return $this->hasMany(User::class,'pouroshova_union_id','id')->where('role','worker');
    }

    public function marketer(){
        return $this->hasMany(User::class,'pouroshova_union_id','id')->where('role','marketer');
    }

    public function membership(){
        return $this->hasMany(User::class,'pouroshova_union_id','id')->where('role','membership');
    }
}
