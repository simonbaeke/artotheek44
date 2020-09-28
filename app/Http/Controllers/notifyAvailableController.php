<?php

namespace App\Http\Controllers;

use App\Artwork;
use App\ArtworkUser;
use App\Http\Resources\ArtworkDetailResource;
use Illuminate\Support\Facades\Auth;

class notifyAvailableController extends Controller
{
    public function __invoke(Artwork $artwork)
    {
        if ($artwork->notify) {
            ArtworkUser::active()->
            where('artwork_id', $artwork->id)
                ->where('user_id', Auth::user()->id)->first()->delete();
        } else {
            ArtworkUser::create([
                'artwork_id' => $artwork->id,
                'user_id' => Auth::user()->id
            ]);
        }

        return new ArtworkDetailResource($artwork);

    }
}
