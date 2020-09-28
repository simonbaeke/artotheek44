<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/03/2019
 * Time: 22:04
 */

namespace App\Actions\Order;


use App\Order;
use App\Subscription;

class CreateOrder
{
    public function execute(Subscription $subscription): Order
    {
        $order = new Order([
            'user_id' => $subscription->user->id,
        ]);

        $subscription->order()->save($order);
    }
}
