<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 15/05/2019
 * Time: 14:47
 */

namespace App\Actions\Artwork;


use App\Artwork;
use Illuminate\Support\Facades\Storage;

class delete
{

    public function execute(Artwork $artwork)
    {

        //check ofdat kunstwerk ontleningen, reserveringen heeft

        if ($artwork->reservations()->count() > 0 || $artwork->rents()->count() > 0) {
            throw new \Exception('kunstwerk heeft ontleningen of reserveringen');
        }


        //delete afbeelding

        Storage::delete('public/img/' . $artwork->thumbnailurl);
        Storage::delete('public/img/thumbnail/' . $artwork->thumbnailurl);


        //delete kunstwerk
        $artwork->delete();

        return true;
    }
}
