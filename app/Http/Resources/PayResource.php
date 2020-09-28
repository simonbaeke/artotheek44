<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $payableResource = "App\Http\Resources\\" . $this->payable_type . "Resource";

        return [
            'id' => $this->id,
            'amount' => intval($this->amount),
            'payable' => new  $payableResource($this->payable),
            'payable_type' => $this->payable_type,
            'payable_id' => intval($this->payable_id),
            'invoice_id' => intval($this->invoice_id),
            'invoice' => new InvoiceResource($this->whenLoaded('invoice'))
        ];
    }
}
