<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PayResource;
use App\Http\Resources\VoucherPayResource;
use App\Pay;
use App\VoucherPay;
use Illuminate\Http\Request;

class VoucherPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'voucher_id' => 'required|exists:vouchers,id',
            'invoice_id' => 'required|exists:invoices,id'
        ]);

        $p = new Pay([
            'invoice_id' => $request->input('invoice_id')
        ]);

        $voucherPay = VoucherPay::create(['amount' => $request->input('amount'),
            'voucher_id' => $request->input('voucher_id')]);

        $p->payable()->associate($voucherPay)->save();

        return new PayResource(Pay::whereId($p->id)->with('invoice')->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(VoucherPay $voucherpay)
    {
        return new VoucherPayResource($voucherpay);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoucherPay $voucherpay)
    {
        $invoice = $voucherpay->pay->invoice;
        $voucherpay->pay()->delete();
        $voucherpay->delete();

        return new InvoiceResource($invoice);

    }
}
