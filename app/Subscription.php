<?php

namespace App;

use App\Http\Filter\Filterable;
use App\Interfaces\Constraint;
use App\Interfaces\Orderable;
use App\Interfaces\Renewable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class Subscription extends Model implements Constraint, Renewable, Orderable
{
    use Filterable;

    protected $fillable = ['user_id', 'active', 'number', 'created_at'];

    const MONTHS = 12;

    public function getExpireAttribute()
    {
        return $this->expires()->orderBy('updated_at', 'desc')->first();
    }

    public function getActiveRentAttribute()
    {
        return $this->rents()->returned(false)->first();
    }

    public function getIsConfirmedAttribute()
    {
        return $this->confirmed()->count() > 0;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function rents()
    {
        return $this->hasMany('App\Rent');
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }

    public function order()
    {
        return $this->morphOne('App\Order', 'orderable');
    }

    public function expires()
    {
        return $this->morphMany('App\Expire', 'expirable');
    }

    public function freeRents()
    {
        return $this->hasMany(FreeRent::class);
    }

    public function freeRent()
    {
        return $this->hasMany(FreeRent::class)->free();
    }

    public function expired()
    {
        if ($this->expires()->count() > 0) {
            return $this->expire->date < \Carbon\Carbon::today();
        }
        return true;
    }

    public function confirmed()
    {
        return $this->hasOne('App\Confirmed');
    }

    public function isAvailable()
    {
        return (($this->rents()->returned(false)->count() + $this->reservations()->active(true)->count()) == 0)
            && !$this->expired();
    }

    public function hasFreeRent()
    {
        return $this->freeRent()->count() > 0;
    }

    public function useFreeRent(Rent $rent)
    {
        return $this->freeRent->useFreeRent($rent);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeAvailable($query)
    {


        return $query->whereDoesntHave('rents', function ($query) {
            $query->returned(false);
        })->whereDoesntHave('reservations', function ($query) {
            $query->valid(true);
        })->whereHas('expires', function ($query) {
            $query->expired(false)->latest()->limit(1);
        });
    }

    public function scopeUserid($query, $userid)
    {
        return $query->where('user_id', $userid);
    }

    static $validationRules = [
        'user_id' => 'required'
    ];

    public function constraint(FormRequest $request)
    {
        Log::channel('single')->info('Subscription constraint');
    }

    public function renewDate()
    {
        if ($this->expire == null) {
            $date = Carbon::now()->addMonth(12)->subDay(1);
        } else {
            $date = Carbon::parse($this->expire->date)->addMonth(12)->subDay(1);
        }

        return $date;
    }

    public function getAmount()
    {
        $this->freeRent()->save(new FreeRent());

        return 25;
    }

    public function getUserId()
    {
        return $this->user->id;
    }

    public function canBeRenewed()
    {
        //invoice laatste expire
        $expirableIds = $this->user->orders()->whereHas('invoice', function ($query) {
            $query->where('confirmed', 'false');
        })->where('orderable_type', 'Expire')->pluck('orderable_id');

        if ($expirableIds->count() > 0) {

            return Expire::find($expirableIds)
                    ->where('expirable_type', 'Subscription')
                    ->where('expirable_id', $this->id)
                    ->count() == 0;
        }

        return true;
    }

    public function canBeDeleted()
    {
        if (!$this->isAvailable()) {
            return false;
        }

        return true;
    }

    public static function createNumber()
    {
        $number = Subscription::max('id') + 10001;
        while (Subscription::where('number', $number)->count() > 0) {
            $number++;
        }

        return $number;
    }


}
