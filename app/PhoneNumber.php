<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    //
    protected $fillable = ['number', 'user_id', 'type_id'];
    protected  $hidden = ['update_at','created_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function type(){
        return $this->belongsTo('App\PhoneNumberType');
    }
}
