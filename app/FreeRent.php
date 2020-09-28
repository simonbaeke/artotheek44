<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeRent extends Model
{
    protected $fillable = ['rent_id', 'subscription_id'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }

    public function scopeFree($query)
    {
        return $query->where('rent_id', null);
    }

    public function useFreeRent(Rent $rent){
        $this->update(['rent_id' => $rent->id]);
    }
}
