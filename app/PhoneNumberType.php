<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumberType extends Model
{
    public function phoneNumbers()
    {
        return $this->hasMany('App\PhoneNumber');
    }
}
