<?php

namespace App\Http\Controllers;

use App\Http\Filter\InvoiceFilter;
use App\Http\Requests\StoreInvoice;
use App\Http\Resources\InvoiceResource;
use App\Invoice;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, InvoiceFilter $filter)
    {

        return InvoiceResource::collection(Invoice::filter($filter)->get());
        //
        if ($request->has('userid')) {
            return InvoiceResource::collection(Invoice::whereUser_id($request->input('userid'))
                ->with('orders')
                ->with('pays')
                ->get());
        }

        return InvoiceResource::collection(Invoice::all());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoice $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //TODO: checken als de betalingen kloppen

        if ($request->has('confirmed ') && $request->input('confirmed') == 'true') {

        }
        $invoice->update($request->all());
        $invoice->save();

        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete alles dat er aanhangt
    }
}
