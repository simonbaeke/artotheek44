<?php

namespace App;

use App\Http\Filter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class ArtworkUser extends pivot
{
    use Filterable;

    protected $fillable = ['user_id', 'artwork_id','notified_at'];

    public function getIsNotifiedAttribute()
    {
        return $this->notified_at != null;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function artwork()
    {
        return $this->belongsTo('App\Artwork')->as('subscription');
    }

    public function scopeNotified($query, $flag){
        if($flag){
            return $query->where('notified_at','!=',null);
        }

        return $query->where('notified_at',null);
    }

    public function scopeActive($query){
        return $query->where('notified_at',null);
    }
}
