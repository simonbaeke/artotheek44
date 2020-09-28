<?php

namespace App;

use App\Http\Filter\Filterable;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use Filterable;

    protected $fillable = ['invoice_id', 'user_id', 'amount'];

    public function getModelAttribute()
    {
        return $this->orderable_type;
    }

    public function getActionAttribute()
    {
        return 'create';
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'orderable_id')
            ->where('orderable_type', 'Subscription');
    }

    public function expire()
    {
        return $this->belongsTo(Expire::class, 'orderable_id')
            ->where('orderable_type', 'Expire');
    }

    public function rent()
    {
        return $this->belongsTo(Rent::class, 'orderable_id')
            ->where('orderable_type', 'Rent');
    }

    public function orderable()
    {
        return $this->morphTo();
    }

    public function scopeOpen($query)
    {
        return $query->where('invoice_id', null);
    }
}
