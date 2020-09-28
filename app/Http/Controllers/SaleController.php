<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleResource;
use App\Sale;
use App\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $validator = Validator::make($request->all(), [
            'artwork_id' => 'required',
        ]);

        if ($validator->fails()) {


        }


        return new SaleResource(Sale::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Artwork $artwork)
    {
        return new SaleResource($artwork->sale);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
