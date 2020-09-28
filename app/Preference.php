<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = ['user_id', 'gdpr', 'notifications', 'newsletter'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
