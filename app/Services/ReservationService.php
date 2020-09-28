<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 21:54
 */

namespace App\Services;


use App\Artwork;
use App\Http\Filter\ReservationFilter;
use App\Http\Resources\ReservationResource;
use App\Notifications\ReservationCreated;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function index(ReservationFilter $filter, Request $request)
    {
        $rowsPerPage = '';
        if ($request->input('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }
        return ReservationResource::collection($this->reservation->filter($filter)->get());
    }

    public function store(array $attributes)
    {
        if (!auth('api')->check()) {
            throw new \Exception('Log in om te reserveren');
        }

        $user = auth('api')->user();

        if (auth('api')->user()->email_verified_at == null) {
            throw new \Exception('Verifieer uw email adres');
        }

        //TODO: als de reserving nog niet verlopen  ==> de reservering terug actief zetten
        //TODO: als de reservering verlopen is kan het kunstwerk niet gereserveerd worden

        //check if object is available
        if (!Artwork::findOrFail($attributes['artwork_id'])->isAvailable()) {
            throw new \Exception('Kunstwerk niet beschikbaar');
        }

        //get first available subscription
        $query = auth('api')->user()->subscriptions()->available();
        if ($query->count() == 0) {
            throw new \Exception('Geen abonnement beschikbaar');
        }

        $subscription = $query->first();
        $attributes = array_merge($attributes,
            ['subscription_id' => $subscription->id]);

        $reservation = $this->reservation->create($attributes);

        $reservation->save();

        $user->notify(new ReservationCreated($reservation));

        return Reservation::findOrFail($reservation->id);

    }

    public function update(Reservation $reservation, array $attributes)
    {
        $reservation->update($attributes);
        return $reservation;
    }
}
