<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'artwork' => new ArtworkSimpleResource($this->artwork),
            'artwork_id' => $this->artwork->id,
            'expire' => new ExpireResource($this->expire),
            'expires_at' => $this->expire->date,
            'returned' => $this->returned_at != null,
            'started_at' =>\Carbon\Carbon::parse($this->created_at)->toDateString() ,
            'returned_at' => $this->returned_at,
            'subscription_id' => $this->subscription->id,
            //'order' => new OrderResource($this->whenLoaded('order')),
            'user'=> new UserSimpleResource($this->subscription->user) ,

        ];
    }
}
