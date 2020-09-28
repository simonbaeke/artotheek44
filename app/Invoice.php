<?php

namespace App;

use App\Http\Filter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use Filterable;

    protected $fillable = ['user_id','confirmed'];

    public function getAmountAttribute(){
           return $this->orders()->sum('amount');
    }

    public function getPayedAmountAttribute()
    {
        return $this->pays->sum('amount');

    }

    public function getFinishedAttribute(){
        return $this->pays->sum('amount') == $this->orders()->sum('amount');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function pays(){
        return $this->hasMany('App\Pay');
    }

    public function scopeNew($query, $userid)
    {
        return $query->whereUser_id($userid)->whereConfirmed(false);
    }

    //invoices met betaling in orde
    public function scopeClosed($query,$userid){

    }

    //invoice met betalingen die nog niet gedaan zijn
    public function scopeOpen($query,$userid){

    }

    //som van te betalen orders < som te betalen pays
    public function scopeFinished($query,$userid,$flag){


        return $query->whereUser_id($userid)->whereConfirmed(false);
    }

    public function scopeUser($query,$userid){
        return $query->whereUser_id($userid);
    }
}
