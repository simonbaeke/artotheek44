<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirmed extends Model
{
    protected $fillable = ['subscription_id'];

    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }

    public function order()
    {
        return $this->morphOne('App\Order', 'orderable');
    }
}
