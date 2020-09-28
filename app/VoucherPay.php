<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherPay extends Model
{
    protected $fillable = ['voucher_id'];
    public function getAmountAttribute()
    {
        return $this->voucher->amount;
    }

    public function voucher()
    {
        return $this->belongsTo('App\Voucher');
    }

    public function pay()
    {
        return $this->morphOne('App\Pay', 'payable');
    }
}
