<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/03/2019
 * Time: 21:55
 */

namespace App\Actions\Subscription;


use App\Subscription;

interface ICreateSubscription
{
    public function execute($attributes): Subscription;
}
