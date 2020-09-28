<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfirmedResource extends JsonResource
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
            'subscription' => new SubscriptionResource($this->subscription),
            'order' => new OrderResource($this->order),
            'subscription_id' => $this->subscription->id
        ];
    }
}
