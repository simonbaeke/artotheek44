<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        App::setLocale("nl");


        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('home');
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {


        //return redirect('/catalogus')->with('message', trans($response));
        return redirect('/catalogus')->with('message', trans('passwords.sent'));
    }
}
