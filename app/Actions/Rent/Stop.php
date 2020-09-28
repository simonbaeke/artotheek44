<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 14/03/2019
 * Time: 16:04
 */

namespace App\Actions\Rent;


use App\Rent;
use App\Artwork;

class Stop
{
    public function execute(Rent $rent)
    {
        $this->stop($rent);
        $rent->artwork->notifyAvailable();
    }

    private function stop(Rent $rent){
        $rent->returned_at = \Carbon\Carbon::today();
        $rent->save();
    }
}
