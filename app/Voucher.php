<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public function getUsedAttribute()
    {
        return $this->voucherPay != null;
    }

    public function getToAttribute()
    {
        $voucherPay = $this->voucherPay;
        if ($voucherPay == null) {
            return null;
        }

        return $voucherPay->pay->invoice->user;

    }

    protected $fillable = ['amount', 'from_id', 'code', 'to_id','koper'];


    public function from()
    {
        return $this->belongsTo('App\User', 'from_id');
    }

    public function to()
    {
        return $this->belongsTo('App\User', 'to_id');
    }

    public function voucherPay()
    {
        return $this->hasOne(VoucherPay::class);
    }

    public function order()
    {
        return $this->morphOne('App\Order', 'orderable');
    }

}
