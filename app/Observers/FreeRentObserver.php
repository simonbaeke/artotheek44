<?php

namespace App\Observers;

use App\FreeRent;
use Illuminate\Support\Facades\Log;

class FreeRentObserver
{
    public function created(FreeRent $freeRent){
        Log::channel('single')->info('freerent created: ' . $freeRent);
    }

    public function updated(FreeRent $freeRent){
        Log::channel('single')->info('freerent updated: ' . $freeRent);

    }

    public function deleted(FreeRent $freeRent){
        Log::channel('single')->info('freerent deleted: ' . $freeRent);

    }
}
