<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpireResource extends JsonResource
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
            'expirable_type' => $this->expirable_type,
            'expirable_id' => $this->expirable_id,
            'date' => Carbon::parse($this->date)->toDateString(),
            'order' => new OrderResource( $this->order()->with('invoice')->first()),
        ];
    }
}
