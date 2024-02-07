<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'packeg_id', 'amount', 'tx_id', 'bank_tx_id', 'purpose', 'current_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membershipPackage()
    {
        return $this->belongsTo(MembershipPackage::class, 'packeg_id');
    }
}
