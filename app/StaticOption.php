<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticOption extends Model
{
    protected $fillable = [
        'option_name',
        'option_value',
    ];
}
