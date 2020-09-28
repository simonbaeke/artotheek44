<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $fillable = ['amount'];

    public function pay()
    {
        return $this->morphOne('App\Pay', 'payable');
    }


}
