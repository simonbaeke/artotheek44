<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Address extends Model
{
    protected $fillable =  ['street','number','zip','city','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
