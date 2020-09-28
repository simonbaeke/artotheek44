<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ArtworkDetailResource extends JsonResource
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
            'name' => $this->name,
            'available' => $this->isAvailable(),
            'thumbnailurl' => asset('../storage/img/thumbnail/' . $this->thumbnailurl),
            'detailurl' =>  asset('../storage/img/' . $this->thumbnailurl),
            'artist' => new ArtistResource($this->artist),
            'rents' => RentResource::collection($this->rents()->orderBy('id','asc')->get()),
            'reservations' => ReservationResource::collection($this->reservations),
            'type' => new TypeResource($this->type),
            'height' => $this->height,
            'width' => $this->width,
            'length' => $this->length,
            'code' => $this->longCode,
            'price' => $this->price,
            'forsale' => $this->forsale,
            'notify' => $this->notify,
            'loggedin' => Auth::check(),
            'sold' => $this->isSold()

        ];
    }
}
