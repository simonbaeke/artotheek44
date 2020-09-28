<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;

class VrijwilligerController extends Controller
{
    //nieuwe vrijwilliger


    public function store(User $user){


        $user->assignRole('vrijwilliger');
        return new UserResource($user);
    }

    public function delete(User $user){
        $user->removeRole('vrijwilliger');
    }


}
