<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'total_amount' => intval($this->amount), //totaal bedrag te betalen
            'payed_amount' => intval($this->payed_amount), //totaal bedrag geselecteerrde betalingen
            'orders' => OrderResource::collection($this->orders),
            'completed' =>boolval($this->payed_amount >= $this->amount) , //alles betaald
            'confirmed' => boolval($this->confirmed), //bevestigd
            'open' => true, //zoek naar open betalingen
            'user_id' => intval($this->user_id),
            'pays' =>PayResource::collection( $this->whenLoaded('pays'))
        ];
    }
}
