<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 16/11/18
 * Time: 10:49
 */

namespace App\Services;


use App\Actions\CreateUser;
use App\Address;
use App\Events\UserStored;
use App\Http\Filter\UserFilter;
use App\Http\Resources\UserResource;
use App\PhoneNumber;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $user, $createUser;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->createUser = new CreateUser();
    }

    public function index(UserFilter $filter, Request $request)
    {
        return $this->user->filter($filter)->with('roles')->get();
        return $this->user->ontlener()->with(['subscriptions.rents', 'subscriptions.reservations'])->filter($filter)->get();
    }

    public function store(array $attributes)
    {
        //$testuser = $this->createUser->execute($attributes);

        //add password
        $password = bin2hex(openssl_random_pseudo_bytes(4));
        $attributes['password'] = Hash::make($password);

        $user = User::create($attributes);

        //aan te passen
        if (empty($attributes['memberid'])) {
            User::where('id', $user->id)->update(['memberid' => $user->id + 10200]);

        }

        foreach ($attributes['roles'] as $role) {
            $user->assignRole($role);
        }
        $user->markEmailAsVerified();

        if (!empty($attributes['street'])) {
            $user->address()->save(new Address([
                'street' => $attributes['street'],
                'number' => $attributes['number'],
                'zip' => $attributes['zip'],
                'city' => $attributes['city']
            ]));
        }

        $notify = $attributes['notify'];


        event(new UserStored($user, $password, $notify));


        return User::findOrFail($user->id);
    }

    public function update(array $attributes)
    {
        $userid = ($attributes['id']);
        $user = User::find($userid);
        $user->firstname = $attributes['firstname'];
        $user->lastname = $attributes['lastname'];
        $user->email = $attributes['email'];

        //telefoonnummers toevoegen
        foreach ($attributes['newPhoneNumbers'] as $phonenumber) {
            if (!empty($phonenumber['number'])) {
                $user->phoneNumbers()->save(new PhoneNumber(['number' => $phonenumber['number'], 'type_id' => $phonenumber['type']]));
            }
        }

        //update bestaande telefoonnummers
        foreach ($attributes['phone'] as $phonenumber) {
            if (!empty($phonenumber['number'])) {
                PhoneNumber::find($phonenumber['id'])->update([
                    'number' => $phonenumber['number'],
                   // 'type_id' => $phonenumber['type']['id']
                ]);
            } else {
                //Verwijderen
            }
        }

        //verwijderde telefoonnummers
        PhoneNumber::destroy($attributes['deletePhoneNumbers']);

        $user->save();

        if (!$user->address) {
            $user->address()->save(new Address([
                'street' => $attributes['street'],
                'number' => $attributes['number'],
                'zip' => $attributes['zip'],
                'city' => $attributes['city']
            ]));
        } else {
            $user->address()->update([
                'street' => $attributes['street'],
                'number' => $attributes['number'],
                'zip' => $attributes['zip'],
                'city' => $attributes['city']
            ]);

            $user->save();
        }


        return User::where('id', $user->id)->first();
    }

    public
    function show(User $user)
    {


        return new UserResource(Auth::User());
    }

    public function storeGpdr(array $attributes)
    {
        $user = Auth::user();
        $user->gdpr = $attributes['gdpr'];
        $user->save();
        return User::findOrFail($user->id);
    }

}
