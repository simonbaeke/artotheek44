<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/03/2019
 * Time: 23:02
 */

namespace App\Actions\Subscription;


use App\Expire;
use App\FreeRent;
use App\Subscription;
use Carbon\Carbon;

class Renew
{
    public function execute(Subscription $subscription)
    {
        $subscription->expires()->save(new Expire(['date' => Carbon::now()->addYear()->subDay()]));
        $subscription->freeRent()->save(new FreeRent());

    }

}
