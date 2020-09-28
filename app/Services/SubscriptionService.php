<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 23:39
 */

namespace App\Services;


use App\Actions\Subscription\CreateNewSubscription;
use App\Actions\Subscription\CreateOldSubscription;
use App\Http\Filter\SubscriptionFilter;
use App\Http\Requests\StoreSubscription;
use App\Http\Resources\SubscriptionDetailResource;
use App\Http\Resources\SubscriptionResource;
use App\Subscription;
use Auth;

class SubscriptionService
{


    public function index(SubscriptionFilter $filter)
    {
        $user = Auth::guard('api')->user() ;
        if (!Auth::guard('api')->user()->hasRole('admin')) {
           return  $user->subscriptions()->active()->get();
        }

        return Subscription::filter($filter)
            ->where('active',true)
            ->with('user')
            ->with('expires')
            ->get();
    }

    public function store(StoreSubscription $request)
    {
        $attributes = $request->all();

        if ($request->has('existing') && $request->input('existing') == true) {


            $createSubscription = new CreateOldSubscription();
        } else {
            $createSubscription = new CreateNewSubscription();
        }

        return $createSubscription->execute($attributes);
    }

    public function show(Subscription $subscription)
    {
        return new SubscriptionResource($subscription);
    }

    public function update(array $attributes, Subscription $subscription)
    {
        $subscription->update($attributes);
        $subscription->save();
        //subscription active == false

        return $subscription;
    }
}
