<?php

namespace App\Observers;

use App\VoucherPay;
use Illuminate\Support\Facades\Log;

class VoucherPayObserver
{
    /**
     * Handle the voucher pay "created" event.
     *
     * @param  \App\VoucherPay $voucherPay
     * @return void
     */
    public function created(VoucherPay $voucherPay)
    {
        Log::channel('single')->info('Voucher used ' . $voucherPay->voucher);

    }

    /**
     * Handle the voucher pay "updated" event.
     *
     * @param  \App\VoucherPay $voucherPay
     * @return void
     */
    public function updated(VoucherPay $voucherPay)
    {
        Log::channel('single')->info('Updating voucher');
    }

    public function updating(VoucherPay $voucherPay)
    {
        Log::channel('single')->info('Updating voucher');
    }

    /**
     * Handle the voucher pay "deleted" event.
     *
     * @param  \App\VoucherPay $voucherPay
     * @return void
     */
    public function deleted(VoucherPay $voucherPay)
    {
        //
    }

    /**
     * Handle the voucher pay "restored" event.
     *
     * @param  \App\VoucherPay $voucherPay
     * @return void
     */
    public function restored(VoucherPay $voucherPay)
    {
        //
    }

    /**
     * Handle the voucher pay "force deleted" event.
     *
     * @param  \App\VoucherPay $voucherPay
     * @return void
     */
    public function forceDeleted(VoucherPay $voucherPay)
    {
        //
    }
}
