<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 6/03/19
 * Time: 23:48
 */

namespace App\Actions;


use App\Subscription;

class CreateSubscription
{

    public function execute($attributes): subscription
    {
        return Subscription::create([
            'user_id' => $attributes['user_id']
        ]);
    }
}
