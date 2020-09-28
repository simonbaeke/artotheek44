<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 6/03/19
 * Time: 17:22
 */

namespace App\Actions;


use App\Rent;
use Carbon\Carbon;
use App\Expire;


class CreateOldRent extends CreateRent
{
    public function execute(array $attributes): Rent
    {
       // return false;
        $rent = Rent::create([
            'artwork_id' => $attributes['artwork_id'],
            'subscription_id' => $attributes['subscription_id'],
            'artwork_id' => $attributes['artwork_id'],
        ]);

        //check object available



        $rent->expires()->save(new Expire(
            ['date' => $rent->renewDate()]));

        if (array_key_exists("returned",$attributes)&& $attributes['returned']){
            $rent->update(['returned_at' => $attributes['return_date']]);
        }

        $rent->update(['created_at' => $attributes['date']]);

        $rent->expire->update(['date' => Carbon::parse($attributes['date'])->addMonth(6)]);

        if (array_key_exists("max_date",$attributes)){
            $rent->expire->update(['date' => $attributes['max_date']]);
        }
        return $rent;

    }


}
