<?php

namespace App\Observers;

use App\BankTransfert;
use Illuminate\Support\Facades\Log;

class BankTransfertObserver
{
    /**
     * Handle the bank transfert "created" event.
     *
     * @param  \App\BankTransfert $bankTransfert
     * @return void
     */
    public function created(BankTransfert $bankTransfert)
    {
        // Creer willekeurig 10 cijferig getal
        $Getal1 = rand(1000000000, 9999999999);

// Rest van willekeurig getal gedeeld door 97
        $Rest = $Getal1 % 97;

        if ($Rest < 10) {
            $Nul = 0;
            $Rest = $Nul . $Rest;
        } else {
        }

//Samenvoegen van willekeuriggetal met rest van deling

        $Merge = $Getal1 . $Rest;

// Print OGM-nummer
        $Ogm = "+++/" . substr($Merge, 0, 3) . "/" . substr($Merge, 3, 4) . "/" . substr($Merge, 7, 5) . "+++";


        $bankTransfert->update([
            "statement" => $Merge
        ]);
    }

    /**
     * Handle the bank transfert "updated" event.
     *
     * @param  \App\BankTransfert $bankTransfert
     * @return void
     */
    public function updated(BankTransfert $bankTransfert)
    {
        //
    }

    /**
     * Handle the bank transfert "deleted" event.
     *
     * @param  \App\BankTransfert $bankTransfert
     * @return void
     */
    public function deleted(BankTransfert $bankTransfert)
    {
        Log::channel('single')->info('Banktransfert deleted: ' . $bankTransfert);

    }

    /**
     * Handle the bank transfert "restored" event.
     *
     * @param  \App\BankTransfert $bankTransfert
     * @return void
     */
    public function restored(BankTransfert $bankTransfert)
    {
        //
    }

    /**
     * Handle the bank transfert "force deleted" event.
     *
     * @param  \App\BankTransfert $bankTransfert
     * @return void
     */
    public function forceDeleted(BankTransfert $bankTransfert)
    {
        //
    }
}
