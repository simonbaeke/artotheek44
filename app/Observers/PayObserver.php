<?php

namespace App\Observers;

use App\Pay;
use Illuminate\Support\Facades\Log;

class PayObserver
{
    /**
     * Handle the pay "created" event.
     *
     * @param  \App\Pay  $pay
     * @return void
     */
    public function created(Pay $pay)
    {
        //
    }

    public function creating(Pay $pay){
        Log::channel('single')->info('new  Pay: '.$pay);



    }

    /**
     * Handle the pay "updated" event.
     *
     * @param  \App\Pay  $pay
     * @return void
     */
    public function updated(Pay $pay)
    {
        //
    }

    /**
     * Handle the pay "deleted" event.
     *
     * @param  \App\Pay  $pay
     * @return void
     */
    public function deleted(Pay $pay)
    {
        Log::channel('single')->info('pay deleted: ' . $pay);

    }

    public function deleting(Pay $pay){
        Log::channel('single')->info('should delete : '. $pay->payable);

        //console
        $pay->payable->delete();
    }

    /**
     * Handle the pay "restored" event.
     *
     * @param  \App\Pay  $pay
     * @return void
     */
    public function restored(Pay $pay)
    {
        //
    }

    /**
     * Handle the pay "force deleted" event.
     *
     * @param  \App\Pay  $pay
     * @return void
     */
    public function forceDeleted(Pay $pay)
    {
        //
    }
}
