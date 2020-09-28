<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\RegisterUser;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpseclib\Crypt\Hash;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/catalogus';
    protected $registerUser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RegisterUser $registerUser)
    {
        $this->middleware('guest');
        $this->registerUser = $registerUser;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => 'required|string',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return (User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['firstname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]));

    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->all();

        $request->has('newsletter')?$data['newsletter'] = true :$data['newsletter'] = false;

        $validator = $this->validator($data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator,'register')->withInput($request->except('token'));
        }

        $user  = $this->registerUser->execute($data);


        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('message','U bent geregistreerd, check alstublieft uw email voor de verificatiemail');
    }
}
