<?php

namespace App\Http\Controllers;

use App\Confirmed;
use App\FreeRent;
use App\Http\Resources\ConfirmedResource;
use App\Http\Resources\SubscriptionResource;
use App\Order;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConfirmController extends Controller
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
        $subscription = Subscription::find($request->input('subscription_id'));

        if ($subscription->confirmed != null) {
            return response()->json(['message' => 'Abonnement reeds bevestigd'], 400);
        }

        $confirm = Confirmed::create([
            'subscription_id' => $subscription->id
        ]);

        $expire = new \App\Expire(["date" => Carbon::now()->addYear(1)]);

        $subscription->expires()->save($expire);

        $confirm->order()->save(new Order(['amount' => 25, 'user_id' => $subscription->user->id]));


        FreeRent::create([
            'subscription_id' => $subscription->id
        ]);

        return new ConfirmedResource($confirm);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ConfirmedResource(Confirmed::findOrFail($id));
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
        Log::channel('single')->info('verwijderen confirm: ' );

        $confirmed= Confirmed::findOrFail($id);

        $confirmed->order()->delete();
        FreeRent::destroy(FreeRent::whereIn('id',$confirmed->subscription->freerent()->pluck('id')));
        Rent::destroy(Rent::whereIn('id',$confirmed->subscription->rentss->pluck('id')));
        if ($confirmed->subscription->expires()->count()>1){
            $confirmed->subscription->expires()->orderBy('id', 'desc')->first()->delete();

        }

        $confirmed->delete();


        //delete expire
        //delete order

        return new SubscriptionResource($confirmed->subscription);
    }
}
