<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 6/03/19
 * Time: 17:15
 */

namespace App\Actions;

use App\Rent;
use App\Order;


class CreateNewRent extends CreateRent
{
    public function execute(array $attributes): Rent
    {
        $rent = parent::execute($attributes);

        $rent->order()->save(new Order(['user_id' => $rent->subscription->user_id,'amount' => 2]));

        if ($rent->subscription->freeRent()->free()->count() > 0) {

            //todo: freesubscriptino terug vrij maken in geval van deleten rent, kan in observer
            $freerent = $rent->subscription->freeRent()->free()->first();
            $freerent->rent()->associate($rent);
            $freerent->save();
            $rent->order->update([
                'amount' => 0
            ]);
        }
        return $rent;
    }

}
