<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Subscription;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function getLoggedInUser()
    {
        return new UserResource(auth('api')->user());
    }

    public function registered()
    {

        return new UserResource(Auth::user());
    }


    //testfuncties
    public function MakeSubscription(Request $request)
    {
        $subscription = Subscription::create([
            'user_id' => $request->input('user_id')
        ]);

        $subscription->expires()->save(new \App\Expire([
            "date" => Carbon::now()->addWeeks(2)
        ]));

        return $subscription;


    }

    public function ConfirmSubscription(Subscription $subscription)
    {
         $subscription->confirmed()->create([]);

         return $subscription->expires()->get();

    }

    public function VerlengSubscription(Request $request)
    {
        $subscription = Subscription::findOrFail($request->input('subscription_id'));

    }

    /*      public function catalogus(Request $request){
            return view('home');
        }

        public function profile(){
            return view('profile');
        }

        public function admin(){
            $user = auth('api')->user();

            return view('admin',compact('user'));
        }*/
}
