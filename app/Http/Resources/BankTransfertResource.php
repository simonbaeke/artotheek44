<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BankTransfertResource extends JsonResource
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
            'amount' => intval($this->amount),
            'confirmed' => boolval($this->confirmed),
            'statement' => "+++/" . substr($this->statement, 0, 3) . "/" . substr($this->statement, 3, 4) . "/" . substr($this->statement, 7, 5) . "+++",
            'pay' => $this->pay,
            'user' => $this->pay->invoice->user,
            'date' => substr($this->created_at,0,10)
        ];
    }
}
