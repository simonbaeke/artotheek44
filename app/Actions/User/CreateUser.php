<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 2/03/19
 * Time: 11:20
 */

namespace App\Actions\User;


use App\Preference;
use App\User;
use Illuminate\Support\Facades\Hash;

class CreateUser implements ICreateUser
{

    public function __construct()
    {

    }

    public function execute(array $data): User
    {

        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            //'phone' => $data['phonenumbers'][0]['number'] ,
            'password' => Hash::make($data['password']),
            'memberid' => User::max('id') + 1001
        ]);


       // $user->phoneNumbers()->save(new PhoneNumber(['number' => $data['phonenumber'], 'type_id' => 1]));

        $user->mailchimpSubscribe();

        $user->mailchimpAddTag("ontlener");

        $user->preferences()->save(new Preference(['newsletter' => $data['newsletter']]));

        return $user;
    }

}
