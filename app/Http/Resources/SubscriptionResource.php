<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SubscriptionResource extends JsonResource
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
            'rents' => RentResource::collection($this->rents),
            'reservations' => ReservationResource::collection($this->reservations),
            'confirmed' => $this->isConfirmed,
            'expire' => $this->expire,
            'active' => $this->active,
            'user_id' => $this->user_id,
            'available' => $this->isAvailable(),
            'order' => new OrderResource($this->whenLoaded('order')),
            'number' => $this->number,
            'started_at' =>\Carbon\Carbon::parse($this->created_at)->toDateString() ,
            'user' => new UserSimpleResource($this->user),
            'expires_at' => $this->expire->date

        ];
    }
}
