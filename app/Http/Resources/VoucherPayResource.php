<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherPayResource extends JsonResource
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
            'id' => intval($this->id),
            'voucher' => ($this->voucher),
            'confirmed' => true,
            'pay' => $this->pay()->with('invoice')->first(),
            'date' => substr($this->created_at,0,10)
        ];
    }
}
