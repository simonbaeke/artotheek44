<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    protected $fillable = ['invoice_id'];

    public function getPayConfirmedAttribute()
    {
        return $this->payable->confirmed;
    }

    public function getAmountAttribute()
    {
        return $this->payable->amount;
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function payable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->hasOneThrough('App\Invoice', 'App\User');
    }
}
