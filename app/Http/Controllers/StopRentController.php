<?php

namespace App\Http\Controllers;

use App\Actions\Rent\Stop;
use App\Http\Resources\RentResource;
use App\Rent;

class StopRentController extends Controller
{
    public function __invoke(Rent $rent, Stop $stopRent)
    {
        $stopRent->execute($rent);

        return new RentResource($rent);
    }
}
