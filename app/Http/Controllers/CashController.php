<?php

namespace App\Http\Controllers;

use App\Cash;
use App\Http\Resources\CashResource;
use App\Http\Resources\PayResource;
use App\Pay;
use Illuminate\Http\Request;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CashResource::collection(Cash::with(['pay','pay.invoice.user'])->get());

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

        $cash = Cash::create(['amount' => $request->input('amount')]);

        $p->payable()->associate($cash)->save();

        return new PayResource(Pay::whereId($p->id)->with('invoice')->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cash $cash)
    {
        return new CashResource($cash);
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
    public function destroy($id)
    {
        //
    }
}
