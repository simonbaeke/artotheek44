<?php

namespace App;

use App\Http\Filter\Filterable;
use App\Interfaces\Renewable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model implements Renewable
{
    use Filterable;

    protected $fillable = ['subscription_id', 'artwork_id', 'active'];

    public function getExpireAttribute()
    {
        return $this->expires()->orderBy('id', 'desc')->first();
    }

    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }

    public function artwork()
    {
        return $this->belongsTo('App\Artwork');
    }

    public function user()
    {
        return $this->subscription()->first()->user();
    }

    public function isActive()
    {
        //$expires = \Carbon\Carbon::createFromFormat('Y-m-d H', $this->expires . " 0");
        return $this->active == true;
    }


    public function expires()
    {
        return $this->morphMany('App\Expire', 'expirable');
    }

    public function expire()
    {
        return $this->expires()->orderBy('id', 'desc')->first()->date;
    }

    public function expired()
    {
        //expired in expire model maken
        return $this->expire() < \Carbon\Carbon::today();
    }

    public function scopeActive($query, $flag)
    {
        return $query->where('active', $flag);
    }

    public function scopeValid($query, $flag)
    {
        if ($flag) {
            return $query->whereHas('expires', function ($query) {
                $query->expired(false);
            })->where('active', true);
        } else {
            return $query->whereDoesntHave('expires', function ($query) {
                $query->expired(false);
            })->orWhere('active', false);
        }
    }

    public function renewDate()
    {
        return Carbon::now()->addWeek(2)->subDay();
    }

    public function canBeRenewed()
    {
        return false;
    }
}
