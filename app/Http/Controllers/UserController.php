<?php

namespace App\Http\Controllers;

use App\Actions\User\AddUser;
use App\Events\UserStored;
use App\Http\Filter\UserFilter;
use App\Http\Requests\StoreGdpr;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserListResource;
use App\Services\UserService;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(UserFilter $filter, Request $request)
    {
        $users = $this->userService->index($filter, $request);

        if ($request->has('list')){
            return UserListResource::collection($users);
        }

        return UserResource::collection($users);
    }

    public function store(StoreUser $request)
    {
        $attributes = $request->all();
        $request->has('newsletter') ? $attributes['newsletter'] = true : $attributes['newsletter'] = false;

        $password = bin2hex(openssl_random_pseudo_bytes(4));
        $attributes['password'] = Hash::make($password);

        $registerUser = new AddUser();

        $user = $registerUser->execute($attributes);

        $notify = $attributes['notify'];

        event(new UserStored($user, $password, $notify));
        return new UserResource($user);
    }

    public function update(UpdateUser $request)
    {
        return new UserDetailResource($this->userService->update($request->all()));
    }

    public function show(User $user)
    {
        if (Auth('api')->user()->hasRole('admin')){
            return new UserDetailResource($user);
        }

        return new UserDetailResource(Auth('api')->user());
    }

    public function gdpr(StoreGdpr $request)
    {
        return $this->userService->storeGpdr($request->all());

    }
}
