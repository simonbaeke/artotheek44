<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionListResource extends JsonResource
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
            'number' => $this->number,
            'started_at' => \Carbon\Carbon::parse($this->created_at)->toDateString(),
            'user' => new UserSimpleResource($this->user),
            'expires_at' => $this->expire->date,
            'confirmed' => $this->isConfirmed,

        ];
    }
}
