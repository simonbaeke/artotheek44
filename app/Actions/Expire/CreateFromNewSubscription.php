<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 14/03/2019
 * Time: 08:24
 */

namespace App\Actions\Expire;


use App\Expire;
use App\FreeRent;
use Carbon\Carbon;

class CreateFromNewSubscription extends Create
{
    public function execute(Array $attributes): Expire
    {
        $attributes['date'] = Carbon::now()->addYear()->subDay();

        $expire = parent::execute($attributes);

        FreeRent::create([
            'subscription_id' => $expire->expirable->id
        ]);

        return $expire;
    }

}
