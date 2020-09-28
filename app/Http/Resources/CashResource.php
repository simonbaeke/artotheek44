<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashResource extends JsonResource
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
            'amount' => $this->amount,
            'confirmed' => true,
            'pay' => $this->pay,
            'user' => $this->pay->invoice->user,
            'date' => substr($this->created_at,0,10)
        ];
    }
}
