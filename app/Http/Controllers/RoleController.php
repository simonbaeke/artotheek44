<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function assign(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);



        $user->assignRole($request->input('role'));
        $user->mailchimpAddTag($request->input('role'));

        return new UserResource($user);

    }

    public function remove(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->removeRole($request->input('role'));
        $user->mailchimpRemoveTag($request->input('role'));


        return new UserResource($user);
    }
}
