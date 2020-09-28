<?php

namespace App\Observers;

use App\Confirmed;
use App\FreeRent;
use App\Rent;
use Illuminate\Support\Facades\Log;

class SubscriptionConfirmedObserver
{
    public function created(Confirmed $confirmed){
        Log::channel('single')->info('confirm created: ' . $confirmed);
    }

    public function updated(Confirmed $confirmed){
        Log::channel('single')->info('confirm updated: ' . $confirmed);

    }

    public function deleted(Confirmed $confirmed){
        Log::channel('single')->info('confirm deleted: ' . $confirmed);

        FreeRent::destroy($confirmed->subscription->freeRent->pluck('id'));
        Rent::destroy($confirmed->subscription->rents->pluck('id')) ;


        Rent::destroy($confirmed->subscription->rents->pluck('id')) ;
        if ($confirmed->subscription->expires()->count()>1){
            $confirmed->subscription->expires()->orderBy('id', 'desc')->first()->delete();

        }
    }
}
