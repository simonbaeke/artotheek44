<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PayResource;
use App\Invoice;
use App\Pay;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PayResource::collection(Pay::with('invoice')->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = Invoice::find($request->input('invoice_id'));

        if ($invoice && $invoice->amount < $invoice->payed_amount + intval($request->input('amount'))) {
            return response()->json(['message' => 'Te betalen bedrag is bereikt'], 400);
        }

        $p = new Pay([
            'invoice_id' => $request->input('invoice_id')
        ]);

        $paymodel = Relation::morphMap()[$request->input('class')]::create($request->all());

        $paymodel->update([
            'amount' => $invoice->amount - $invoice->payedAmount
        ]);

        $p->payable()->associate($paymodel)->save();

        return new InvoiceResource(Invoice::find($request->input('invoice_id')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Pay $pay)
    {
        $invoice = $pay->invoice;
        //delete this
        $pay->delete();

        //delete wat eraan vasthangt
        return new InvoiceResource($invoice);

    }
}
