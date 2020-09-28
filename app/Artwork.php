<?php

namespace App;

use App\Http\Filter\Filterable;
use App\Notifications\ArtworkAvailableNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class Artwork extends Model
{
    use Filterable;

    protected $fillable = ['forsale', 'artist_id', 'type_id', 'name', 'thumbnailurl', 'width', 'height', 'length', 'code', 'price'];

    public function getLongCodeAttribute()
    {
        $type = str_pad($this->type->type_code, 2, "0", STR_PAD_LEFT);
        $id = str_pad($this->code, 3, "0", STR_PAD_LEFT);

        return $type . "-" . $this->artist->short . "-" . $id;
    }

    public function getNotifyAttribute()
    {
        if (!Auth::check()) {
            return false;
        }

        return ArtworkUser::
            where('artwork_id', $this->id)
                ->where('notified_at', null)
                ->where('user_id', Auth::user()->id)
                ->count() > 0;
    }

    public
    function artist()
    {
        return $this->belongsTo('App\Artist');
    }

    public
    function rents()
    {
        return $this->hasMany('App\Rent');
    }

    public
    function reservations()
    {
        return $this->hasMany('App\Reservation');
    }

    public
    function type()
    {
        return $this->belongsTo('App\Type');
    }

    public
    function sale()
    {
        return $this->hasOne('App\Sale');
    }

    public function usersToNotify()
    {
        return $this->belongsToMany('App\User')
            ->using('App\ArtworkUser')
            ->wherePivot('notified_at', null);
           //->withPivot('id');
    }

    public
    function scopeAvailable($query)
    {
        return $query->whereDoesntHave('rents', function ($q) {
            return $q->where('returned_at', null);
        })->whereDoesntHave('reservations', function ($q) {
            return $q->whereDoesntHave('expires', function ($query) {
                $query->expired(false);
            })->orWhere('active', false);
        });
    }

    public function scopeSold($query, $flag)
    {
        if ($flag) {
            return $query->has('sale');
        }

        return $query->doesntHave('sale');
    }


    public
    function isAvailable()
    {
        return ($this->rents()->returned(false)->count() +
            $this->reservations()->valid(true)->count()

            == 0 ) && ! $this->isSold();

    }

    public function isSold()
    {
        return $this->sale()->count() > 0;
    }

    public function notifyAvailable()
    {

        Notification::send($this->usersToNotify, new ArtworkAvailableNotification($this));

        // echo $this->usersToNotify()->updateExistingPivot($roleId, $attributes);

        /* ArtworkUser::where('artwork_id', $this->id)
             ->whereIn('user_id', $this->usersToNotify()->pluck('id'))
             ->whereNull('notified_at')
             ->update([
                 'notified_at' => Carbon::now()
             ]);*/

        return true;
    }


    public function setNotified(){

    }


}
