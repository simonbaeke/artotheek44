<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'id' => $this->id,
            'artwork' => new ArtworkResource($this->artwork),
            'user_id' => $this->subscription->user->id,
            'user' => new UserResource($this->subscription->user),
            'expire' => $this->expire,
            'active' => $this->isActive(),
            'expired' => $this->expired(),
            'subscription_id' => $this->subscription->id,
            'subscription' => $this->subscription,
            'expires_at' => $this->expire->date
        ];
    }
}
