<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControllerNotice extends Model
{
    protected $fillable = [
        'controller_id',
        'title',
        'detail',
    ];

    //Controller
    public function controller(){
        return $this->belongsTo(User::class,'controller_id','id');
    }

    public function scopeActive($query){
        return $query->where('is_active',1);
    }

    public function scopeInactive($query){
        return $query->where('is_active',0);
    }

    public function scopeDistrict($query,$district){
        if ($district && $district != 'Áll'){
            return $query->whereHas('controller',function ($query) use ($district){
                $query->where('district_id',$district);
            });
        }
        return $query;
    }

    public function scopeUpazila($query,$upazila){
        if ($upazila && $upazila != 'Áll'){
            return $query->whereHas('controller',function ($query) use ($upazila){
                $query->where('upazila_id',$upazila);
            });
        }
        return $query;
    }
}
