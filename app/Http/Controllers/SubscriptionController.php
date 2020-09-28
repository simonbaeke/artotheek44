<?php

namespace App\Http\Controllers;

use App\Expire;
use App\Http\Filter\SubscriptionFilter;
use App\Http\Requests\StoreSubscription;
use App\Http\Resources\SubscriptionDetailResource;
use App\Http\Resources\SubscriptionListResource;
use App\Http\Resources\SubscriptionResource;
use App\Rent;
use App\Services\SubscriptionService;
use App\Subscription;
use Illuminate\Http\Request;


class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SubscriptionFilter $filter)
    {


        if ($request->has('list') && $request->input('list') == true){
            return SubscriptionListResource::collection($this->subscriptionService->index($filter));
        }


        return SubscriptionDetailResource::collection($this->subscriptionService->index($filter));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscription $request)
    {
        $request->validate([
            'started_at' => 'required',
            'expires_at' => 'required',
            'number' => 'required|unique:subscriptions',
            'user_id' => 'required',
            'confirmed' => 'required|boolean',
            'active' => 'required|boolean',
        ]);

        try {
            return new SubscriptionResource($this->subscriptionService->store($request));

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {

        return new SubscriptionResource($subscription);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        try {

            //Deze code moet ergens anders komen
            if ($request->has('active') && $request->input('active') == false) {
                //check
                if ($subscription->activeRent != null) {
                    return response()->json(['message' => 'Er is nog een ontlening actief'], 400);
                }
            }

            return new SubscriptionResource($this->subscriptionService->update($request->all(), $subscription));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //verwijder expire order

        if (!$subscription->canBeDeleted()){
          return   response()->json(['message' => 'Ontlening of reservering actief'], 400);
        }

        Expire::destroy($subscription->expires()->pluck('id'));

        $subscription->confirmed()->delete();
        $order = $subscription->order;
        //delete rents en reservations
        Rent::destroy($subscription->rents()->pluck('id'));

        if ($order) {
            $order->delete();

        }
        //$subscription->order()->delete();
        $subscription->delete();

        return response()
            ->json(['deleted']);

    }

    public function getNumber()
    {
        return response()
            ->json(['number' => Subscription::createNumber()]);
    }
}
