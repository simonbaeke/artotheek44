<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 11/03/19
 * Time: 13:02
 */

namespace App\Actions\User;


use App\User;

class RegisterUser extends CreateUser
{


    /**
     * @param array $attributes
     * @return \App\User|void
     */
    public function execute(Array $attributes): User
    {
        $user = parent::execute($attributes);

        $user->assignRole('ontlener');

        return $user;

    }
}
