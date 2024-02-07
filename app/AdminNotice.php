<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminNotice extends Model
{
    protected $fillable = [
        'admin_id',
        'title',
        'detail',
        'status'
    ];

    //Admin
    public function admin(){
        return $this->belongsTo(User::class,'admin_id','id');
    }

    public function scopeActive($query){
        return $query->where('status',1);
    }

    public function scopeInactive($query){
        return $query->where('status',0);
    }

}
