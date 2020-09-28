<?php

namespace App\Observers;

use App\Invoice;
use App\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order $order
     * @return void
     */
    public function created(Order $order)
    {
        //invoice
        $invoice = Invoice::new($order->user_id)->first();
        if (!$invoice) {
            Log::channel('single')->info('new  Invoice: ');

            $invoice = Invoice::create(['user_id' => $order->user_id]);
        }

        $invoice->orders()->save($order);
        if ($order->orderable_type == 'Voucher') {
            $amount = $order->amount;

            $order->update([
                'amount' => $amount
            ]);

        }

        if ($order->orderable_type == 'Confirmed') {
            $amount = 25;

            $order->update([
                'amount' => $amount
            ]);
        }


    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order $order
     * @return void
     */
    public function deleting(Order $order)
    {
        Log::channel('single')->info('delete Order: ' . $order);


    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }


}
