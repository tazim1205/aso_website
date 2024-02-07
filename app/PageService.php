<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageService extends Model
{
    use SoftDeletes;

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function service()
    {
        return $this->belongsTo(WorkerService::class, 'service_id');
    }
}
