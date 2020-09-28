<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoucherResource;
use App\Order;
use App\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VoucherResource::collection(Voucher::with(['from', 'to'])->get());
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
            'from_id' => 'sometimes|exists:users,id',
            'registered' => 'required',
            'existing' => 'required',
            'koper' => 'sometimes|required'
        ]);

        if ($request->input('existing') == true) {

            $request->validate([
                'code' => 'required|unique:vouchers,code',
            ]);
        }


        $voucher = Voucher::create([
            'amount' => 25,
            'from_id' => $request->has('from_id') ? $request->input('from_id') : null,
            'code' => $request->input('existing') == true ? $request->input('code') : $this->makeId(),
            'koper' => $request->has('koper') ? $request->input('koper') : ""
        ]);


        if (!$request->input('existing')) {

            $voucher->order()->save(new Order([
                'amount' => $request->input('amount'),
                'user_id' => $request->input('from_id')
            ]));
        }


        return new VoucherResource($voucher);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new VoucherResource(Voucher::find($id));
    }

    /**
     *
     */
    public function check(Request $request)
    {
        $voucher = Voucher::where('code', $request->input('code'))->first();
        //bestaat
        if ($voucher == null) {
            return response()->json(['message' => 'Cadeaubon niet teruggevonden'], 400);

        }
        if ($voucher->used) {
            return response()->json(['message' => 'Cadeaubon is al gebruikt'], 400);

        }

        //nog niet gebruikt


        return new VoucherResource(Voucher::where('code', $request->code)->first());

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

    public function makeId()
    {


        //$id = Voucher::max('id') + 1;

        $id = strtoupper(substr(md5(microtime()), rand(0, 26), 5));
        while (!Voucher::where('code', $id)->count() == 0) {
            $id++;
        }

        return $id;
    }
}
