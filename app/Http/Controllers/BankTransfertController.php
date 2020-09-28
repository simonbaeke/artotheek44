<?php

namespace App\Http\Controllers;

use App\BankTransfert;
use App\Http\Resources\BankTransfertResource;
use App\Http\Resources\PayResource;
use App\Pay;
use Illuminate\Http\Request;

class BankTransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BankTransfertResource::collection(BankTransfert::with(['pay','pay.invoice.user'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $p = new Pay([
            'invoice_id' => $request->input('invoice_id')
        ]);

        $banktransfert = BankTransfert::create(['amount' => $request->input('amount')]);

        $p->payable()->associate($banktransfert)->save();

        return new PayResource(Pay::whereId($p->id)->with('invoice')->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$btids = Pay::where('invoice_id', $id)->where('payable_type', 'BankTransfert')->pluck('payable_id');

        return new BankTransfertResource(BankTransfert::find($id));
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


    }

    public function check($statement)
    {
        $banktransfert = BankTransfert::where('statement', $statement)->first();
        if ($banktransfert && !$banktransfert->confirmed) {
            $banktransfert->confirmed = true;
            $banktransfert->save();
            return new BankTransfertResource($banktransfert);
        } else if (!$banktransfert) {
            return response()->json(['message' => 'Overschrijving niet gevonden'], 400);

        } else if ($banktransfert && $banktransfert->confirmed) {
            return response()->json(['message' => 'Overschrijving was al bevestigd'], 400);

        } else {
            return response()->json(['message' => 'Probleem met bevestigen overschrijving'], 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankTransfert $banktransfert)
    {
        $invoice = $banktransfert->pay->invoice;
        $banktransfert->pay()->delete();
        $banktransfert->delete();

        return new InvoiceResource($invoice);
    }
}
