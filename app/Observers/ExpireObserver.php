<?php

namespace App\Observers;

use App\Expire;
use App\FreeRent;
use App\Subscription;
use Illuminate\Support\Facades\Log;

class ExpireObserver
{
    /**
     * Handle the expire "created" event.
     *
     * @param  \App\Expire $expire
     * @return void
     */


    public function created(Expire $expire)
    {

        Log::channel('single')->info('expire created: ' . $expire);


        if ($expire->expirable_type == 'Subscription' && $expire->expirable->confirmed) {

        }
        //$expire->expirable->expire == nieuwe datum: zinloos


        /*        $ex = $expire->expirable->expires()->orderBy('id', 'desc')->skip(1)->first();
                if (!$ex) {
                    $ex = $expire->expirable->expire;
                } else {
                    $ex = $ex->date;
                }

                //TODO problem : expire < subscription->expire
                //TODO indien auth role ontlener : subscription 2 weken geldig

                //if !expire has order && expirable_type == rent
                if ($expire->expirable_type == 'Subscription') {
                    $expire->update([
                        'date' => Carbon::parse($ex)->addMonth(12)
                    ]);
                } else if ($expire->expirable_type == 'Rent') {

                    //echo min(Carbon::parse($ex)->addMonth(12), $expire->expirable->subscription->expire);
                    $expire->update([
                        'date' => Carbon::parse($ex)->addMonth(6)
                    ]);

                } else {
                    $expire->update([
                        'date' => Carbon::parse($ex)->addWeek(2)
                    ]);
                }

                $expire->save();*/

    }

    /**
     * Handle the expire "updated" event.
     *
     * @param  \App\Expire $expire
     * @return void
     */
    public function updated(Expire $expire)
    {


    }

    /**
     * Handle the expire "deleted" event.
     *
     * @param  \App\Expire $expire
     * @return void
     */
    public function deleted(Expire $expire)
    {
        Log::channel('single')->info('Expire deleted: ' . $expire);


        //verwijder gratis ontlening indien een verlenging van abonnement verwijderd wordt
        if ($expire->expirable_type == 'Subscription' && $expire->expirable != null){
            $subscription = Subscription::find($expire->expirable->id);

            if ($subscription->freeRent()->count()>0){
                FreeRent::whereIn('id',$subscription->freeRent->pluck('id'))->orderBy('id','desc')->first()->delete ();

            }

        }
        $expire->order()->delete();
    }

    /**
     * Handle the expire "restored" event.
     *
     * @param  \App\Expire $expire
     * @return void
     */
    public function restored(Expire $expire)
    {
        //
    }

    /**
     * Handle the expire "force deleted" event.
     *
     * @param  \App\Expire $expire
     * @return void
     */
    public function forceDeleted(Expire $expire)
    {
        //
    }
}
