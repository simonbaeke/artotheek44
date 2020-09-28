<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/03/2019
 * Time: 22:20
 */

namespace App\Actions\Subscription;

use App\Subscription;
use App\Confirmed;

class CreateOldSubscription extends CreateSubscription
{
    public function execute($attributes): Subscription
    {

        return parent::execute($attributes);

    }

}
