<?php

namespace App\Observers;

use App\ArtworkUser;
use App\Expire;
use App\Notifications\RentCreated;

use App\Rent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RentObserver
{
    /**
     * Handle the rent "created" event.
     *
     * @param  \App\Rent $rent
     * @return void
     */
    public function created(Rent $rent)
    {
        Log::channel('single')->info('Rent created ' . $rent . " " . $rent->subscription->user);

        //expire
        $rent->expires()->save(new Expire(
            ['date' => Carbon::now()->addYear()->subDay(1)]));

        $notication = new RentCreated($rent);

        $rent->subscription->user->sendMailchimp($notication->toArray());

    }

    /**
     * Handle the rent "updated" event.
     *
     * @param  \App\Rent $rent
     * @return void
     */
    public function updated(Rent $rent)
    {
        if (!$rent->returned) {
            // $rent->subscription->user->notify(new ReturnRentNotificaton($rent));
        }

        if ($rent->artwork->isAvailable()) {
            $user_ids = ArtworkUser::where('artwork_id', $rent->artwork->id)->where('notified_at', null)->get()->pluck('user_id');
            //Log::channel('single')->info('users to notify ' . $user_ids);

            //set notifiers to inactive
            //NotifyArtworkAvailable::whereIn('user_id', $user_ids->all())->update(['active' => false]);

            //mail
            // Mail::to(User::find($user_ids))->send(new ArtworkAvailable($rent->artwork));
            //$rent->subscription->user->notify(new ReturnRentNotificaton($rent));

        }


        //$rent->subscription->user->sendMailchimp($notication->toArray());
    }

    public function deleting(Rent $rent)
    {

        //check if $rent has order
        if ($rent->order != null){
            $rent->order->delete();

        }
    }

    /**
     * Handle the rent "deleted" event.
     *
     * @param  \App\Rent $rent
     * @return void
     */
    public function deleted(Rent $rent)
    {
        Log::channel('single')->info('Rent deleted ' . $rent . " " . $rent->subscription->user);


        if ($rent->order != null){
            $rent->order->delete();

        }
        Expire::destroy($rent->expires()->pluck('id'));

        if ($rent->freeRent) {
            $rent->freeRent->update(['rent_id' => null]);

        }
    }

    /**
     * Handle the rent "restored" event.
     *
     * @param  \App\Rent $rent
     * @return void
     */
    public function restored(Rent $rent)
    {
        //
    }

    /**
     * Handle the rent "force deleted" event.
     *
     * @param  \App\Rent $rent
     * @return void
     */
    public function forceDeleted(Rent $rent)
    {
        //
    }
}
