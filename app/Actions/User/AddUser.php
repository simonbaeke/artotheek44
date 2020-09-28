<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 12/03/19
 * Time: 10:58
 */

namespace App\Actions\User;


use App\Address;
use App\PhoneNumber;
use App\User;

class AddUser extends CreateUser
{
    public function __construct()
    {
    }

    public function execute(Array $data): User
    {

        $user = parent::execute($data);
        $user->markEmailAsVerified();

        foreach ($data['roles'] as $role) {
            $user->assignRole($role);
        }

        //telefoonnumbers toevoegen
        foreach ($data['phonenumbers'] as $phonenumber) {
            if(!empty($phonenumber['number'])){
                $user->phoneNumbers()->save(new PhoneNumber(['number' => $phonenumber['number'],'type_id'=>$phonenumber['type']]));
            }
        }

        if (!empty($data['street'])) {
            $user->address()->save(new Address([
                'street' => $data['street'],
                'number' => $data['number'],
                'zip' => $data['zip'],
                'city' => $data['city']
            ]));
        }

        return $user;

    }

}
