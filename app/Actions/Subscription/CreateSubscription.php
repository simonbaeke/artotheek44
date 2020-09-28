<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 6/03/19
 * Time: 23:48
 */

namespace App\Actions\Subscription;


use App\Subscription;
use App\Confirmed;
use Carbon\Carbon;

class CreateSubscription implements ICreateSubscription
{

    public function execute($attributes): Subscription
    {

        $subscription = Subscription::create([
            'user_id' => $attributes['user_id'],
            'active' => true,
            'number' =>  array_key_exists('number',$attributes)?$attributes['number']:Subscription::createNumber(),
            'started_at' => array_key_exists('started_at',$attributes)?$attributes['started_at']:Carbon::now()
        ]);
        
        $subscription->expires()->save(new \App\Expire(["date" => array_key_exists('expires_at',$attributes)?$attributes['expires_at']:Carbon::now()->addDays(14)]));

        if (array_key_exists('confirmed',$attributes) && $attributes['confirmed']) {
            $subscription->confirmed()->save(new Confirmed());
        }

        return $subscription;
    }
}
