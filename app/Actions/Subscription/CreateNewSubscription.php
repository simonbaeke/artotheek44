<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/03/2019
 * Time: 21:51
 */

namespace App\Actions\Subscription;


use App\Confirmed;
use App\Order;
use App\Subscription;
use Carbon\Carbon;

class CreateNewSubscription extends CreateSubscription implements ICreateSubscription
{


    public function execute($attributes): Subscription
    {
        $subscription = parent::execute($attributes);

        $order = new Order(
            [
                'amount' => $subscription->getAmount(),
                'user_id' => $subscription->user->id
            ]);

        $subscription->order()->save($order);

        return $subscription;
    }
}
