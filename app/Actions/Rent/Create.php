<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 14/03/2019
 * Time: 16:03
 */

namespace App\Actions\Rent;


use App\Expire;
use App\Rent;

class Create
{

    public function execute(Array $attributes): Rent
    {
        $rent = Rent::create([
            'subscription_id' => $attributes['subscription_id'],
            'artwork_id' => $attributes['artwork_id'],
        ]);

        return $rent;

        // $rent->order()->save(new Order['amount' => $]);
    }

}
