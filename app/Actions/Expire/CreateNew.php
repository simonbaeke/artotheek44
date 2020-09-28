<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 24/02/2020
 * Time: 18:41
 */

namespace App\Actions\Expire;


use App\Expire;

class CreateNew
{
    public function execute(Array $attributes): Expire
    {

        try {
            $expire = new Expire([
                'expirable_type' => $attributes['expirable_type'],
                'expirable_id' => $attributes['expirable_id']]);
        } catch (\Exception $e) {
            throw $e;
        }


        $expire->save();


        return $expire;
    }
}
