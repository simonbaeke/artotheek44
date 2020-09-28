<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankTransfert extends Model
{

    protected $fillable=['completed','statement','amount'];
    public function pay()
    {
        return $this->morphOne('App\Pay', 'payable');
    }
}
