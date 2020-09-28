<?php

namespace App\Observers;

use App\Expire;
use App\FreeRent;
use App\Order;
use App\Rent;
use App\Reservation;
use App\Subscription;
use Illuminate\Support\Facades\Log;

class SubscriptionObserver
{
    /**
     * Handle the subscription "created" event.
     *
     * @param  \App\subscription $subscription
     * @return void
     */
    public function created(Subscription $subscription)
    {
        Log::channel('single')->info('create Subscription: ' . $subscription);
        //if geen admin: 1 jaar g
        /*        $weeks = 2;


                //of $subscription has order
                //if (auth()->user()->hasRole('admin'))
                {
                    $weeks = 52;
                    $subscription->confirmed()->save(new Confirmed([]));
                }

                $subscription->expires()->save(new \App\Expire([
                    "date" => Carbon::now()->addMonth(1)]));*/


    }

    /**
     * Handle the subscription "updated" event.
     *
     * @param  \App\subscription $subscription
     * @return void
     */
    public function updated(Subscription $subscription)
    {
        //
    }

    public function deleting(Subscription $subscription)
    {
        $subscription->order()->delete();
        FreeRent::where('subscription_id', $subscription->id)->delete();

        Rent::destroy($subscription->rents()->pluck('id'));
        Reservation::destroy($subscription->reservations()->pluck('id'));

    }


    /**
     * Handle the subscription "deleted" event.
     *
     * @param  \App\subscription $subscription
     * @return void
     */
    public function deleted(Subscription $subscription)
    {
        Log::channel('single')->info('delete Subscription: ' . $subscription);
        $expireids = $subscription->expires()->pluck('id');
        $orderids = Order::where('orderable_type', 'Expire')->whereIn('orderable_id', $expireids)->delete();


        Expire::destroy($expireids);
        $subscription->confirmed()->delete();
    }

    /**
     * Handle the subscription "restored" event.
     *
     * @param  \App\subscription $subscription
     * @return void
     */
    public function restored(Subscription $subscription)
    {
        //
    }

    /**
     * Handle the subscription "force deleted" event.
     *
     * @param  \App\subscription $subscription
     * @return void
     */
    public function forceDeleted(Subscription $subscription)
    {
        Log::channel('single')->info('delete Subscription: ' . $subscription);

        $subscription->expires()->delete();
        $subscription->confirmed()->delete();
    }
}
