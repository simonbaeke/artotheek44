<?php

namespace App\Observers;

use App\Artwork;

class ArtworkObserver
{
    public function creating(Artwork $artwork){
        //generate code
        if(empty($artwork->code)){
            $type = str_pad($artwork->type->type_code,2,"0",STR_PAD_LEFT);
            $id = str_pad($artwork->artist->artworks()->count(),3,0,STR_PAD_LEFT);

            $code = $type . " - " . $artwork->artist->short ." - " . $id;
            $artwork->code = $code;
        }

    }

    /**
     * Handle the artwork "created" event.
     *
     * @param  \App\artwork  $artwork
     * @return void
     */
    public function created(Artwork $artwork)
    {
        //
    }

    /**
     * Handle the artwork "updated" event.
     *
     * @param  \App\artwork  $artwork
     * @return void
     */
    public function updated(Artwork $artwork)
    {
        //
    }

    /**
     * Handle the artwork "deleted" event.
     *
     * @param  \App\artwork  $artwork
     * @return void
     */
    public function deleted(Artwork $artwork)
    {
        //
    }

    /**
     * Handle the artwork "restored" event.
     *
     * @param  \App\artwork  $artwork
     * @return void
     */
    public function restored(Artwork $artwork)
    {
        //
    }

    /**
     * Handle the artwork "force deleted" event.
     *
     * @param  \App\artwork  $artwork
     * @return void
     */
    public function forceDeleted(Artwork $artwork)
    {
        //
    }
}
