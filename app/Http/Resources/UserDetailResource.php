<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
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
            'email' => $this->email,
            'id' => $this->id,
            'is_admin' => $this->hasRole('admin'),
            'is_superadmin' => $this->hasRole('superAdmin'),
            'fullname' => $this->firstname . " " . $this->lastname,
            'verified' => $this->email_verified_at != null,
            'roles' => RoleResource::collection($this->roles),
            'phone' => $this->phoneNumbers,
            'address' => new AddressResource($this->address),
            'phoneNumbers' => PhoneNumberResource::collection($this->phoneNumbers),
            'preferences' => $this->preferences
        ];
    }
}
