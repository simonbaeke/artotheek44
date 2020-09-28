<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 6/03/19
 * Time: 16:44
 */

namespace App\Actions;

use App\Artwork;
use App\Rent;
use App\Subscription;


class CreateRent
{

    public function __construct()
    {

    }

    public function execute(array $attributes): Rent
    {
        if (array_key_exists('type', $attributes) && $attributes['type'] == 'Code') {

            $artworks = Artwork::all();
            $artwork = $artworks->firstWhere('long_code',$attributes['artwork_code']);


            if ($artwork == null){
                throw new \Exception('Kunstwerk niet gevonden met code ' . $attributes['artwork_code'] . " niet gevonden");
            }

            $attributes['artwork_id']  = $artwork->id;


        } else {
           $artwork =  Artwork::findOrFail($attributes['artwork_id']);
        }

       // var_export($artwork->isAvailable());

        if (!$artwork->isAvailable()) {


           // $artwork = Artwork::findOrFail($attributes['artwork_id']);
            $subscription = Subscription::findOrFail($attributes['subscription_id']);
            $reservation = $artwork->reservations()->valid(true)->first();

            if (!($reservation && $reservation->subscription->id == $subscription->id)) {
                throw new \Exception('Kunstwerk niet beschikbaar');

            } else {
                $reservation->active = false;
                $reservation->save();
            }

        }


        $subscription = Subscription::findOrFail($attributes['subscription_id']);
        //abonnement niet geconfirmeerd
        if (!$subscription->confirmed) {
            if ($reservation) {
                $reservation->active = true;
                $reservation->save();
            }
            throw new \Exception('Abonnement nog niet geconfirmeerd');
        }

        //abonnement verlopen
        if ($subscription->expired()) {
            throw new \Exception('Abonnement is verlopen');
        }

        //check  subscription available
        if (!$subscription->isAvailable()) {

            throw new \Exception('Abonnement niet beschikbaar');
        }

        //check subscription is active
        if (!$subscription->active) {
            throw new \Exception('Abonnement is niet actief');
        }


        //
        $rent = Rent::create($attributes);

        return $rent;
    }

}
