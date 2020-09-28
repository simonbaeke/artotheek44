<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'invoice_id' => intval($this->invoice_id),
            'orderable' => $this->orderable,
            'orderable_type' => $this->orderable_type,
            'orderable_id' => intval($this->orderable_id),
            'amount' => doubleval($this->amount),
            'model' => $this->model,
            'action' => $this->action,
            'user' => $this->user->id,
            'invoice' => new InvoiceResource($this->whenLoaded('invoice'))
        ];
    }
}
