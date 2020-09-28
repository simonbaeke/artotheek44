<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $this->firstname . " " . $this->lastname,
            'email' => $this->email,
            'roles' => RoleResource::collection($this->roles),
            'id' => $this->id,
            'verified' => $this->email_verified_at != null,
            //'phone' => $this->phoneNumbers,
            //'preferences' => $this->preferences,
            'token' => $this->when(Auth::check() && Auth::user()->id == $this->id, $this->createToken('api')->accessToken),
        ];
    }
}
