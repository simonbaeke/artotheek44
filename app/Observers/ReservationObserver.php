<?php

namespace App\Observers;

use App\Expire;
use App\Notifications\ReservationCreated;
use App\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReservationObserver
{
    /**
     * Handle the reservation "created" event.
     *
     * @param  \App\Reservation $reservation
     * @return void
     */
    public function created(Reservation $reservation)
    {
        Log::channel('single')->info('reservation created: ' . $reservation);

        $reservation->expires()->save(new \App\Expire([
            "date" => Carbon::now()->addWeek(2)]));

        $notication = new ReservationCreated($reservation);

        $reservation->subscription->user->sendMailchimp($notication->toArray());
    }

    /**
     * Handle the reservation "updated" event.
     *
     * @param  \App\Reservation $reservation
     * @return void
     */
    public function updated(Reservation $reservation)
    {
        Log::channel('single')->info('reservation updated: ' . $reservation);

    }

    /**
     * Handle the reservation "deleted" event.
     *
     * @param  \App\Reservation $reservation
     * @return void
     */
    public function deleted(Reservation $reservation)
    {
        Log::channel('single')->info('reservation deleted: ' . $reservation);
        Expire::destroy($reservation->expires()->pluck('id'));
    }

    /**
     * Handle the reservation "restored" event.
     *
     * @param  \App\Reservation $reservation
     * @return void
     */
    public function restored(Reservation $reservation)
    {
        //
    }

    /**
     * Handle the reservation "force deleted" event.
     *
     * @param  \App\Reservation $reservation
     * @return void
     */
    public function forceDeleted(Reservation $reservation)
    {
        //
    }
}
