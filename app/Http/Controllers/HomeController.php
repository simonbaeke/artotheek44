<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Psy\Util\Json;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $showlogin = true;
        if (Auth::check()) {
            $user = Json::encode(new UserResource(User::whereId(Auth::user()->id)->with('roles')->first()));
            return view('home', compact('user', 'showlogin'));
        }


        return view('home', compact('showlogin'));
    }


    public function login(Request $request)
    {
        return view('home')->with('showlogin', true);
    }
}
