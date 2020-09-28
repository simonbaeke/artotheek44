<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            'from' => new UserSimpleResource($this->from),
            'to' => new UserSimpleResource($this->to),
            'amount' => $this->amount,
            'code' => $this->code,
            'used' => $this->used,
            'koper' => $this->from==null?$this->koper:$this->from->fullname
        ];
    }
}
