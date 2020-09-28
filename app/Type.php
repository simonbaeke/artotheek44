<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    protected $fillable = ['name','type_code'];

    public function artworks()
    {
        return $this->hasMany('App\Artwork');
    }
}
