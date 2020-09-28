<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 23:39
 */

namespace App\Services;


use App\Actions\Rent\Stop;
use App\Http\Filter\RentFilter;
use App\Rent;
use Carbon\Carbon;
use Illuminate\Http\Request;


class RentService
{
    protected $rent;

    public function __construct(Rent $rent)
    {
        $this->rent = $rent;
    }

    public function index(RentFilter $rentFilter, Request $request)
    {
        return Rent::filter($rentFilter)->with(['subscription', 'subscription.user', 'expires', 'artwork'])->get();
    }

    public function store($attributes, $createRent)
    {


        $rent = $createRent->execute($attributes);
        return Rent::findOrFail($rent->id);
    }

    public function storeOld($attributes, $createRent)
    {
        $rent = $this->storeOld($attributes);
        return Rent::findOrFail($rent->id);

    }

    public function update(Request $request, $rent)
    {

        $attributes = $request->all();

        if ($request->has('returned') && $request->input('returned')==true){
            $rent->update([
                'returned_at' => Carbon::now()
            ]);

            return Rent::findOrFail($rent->id);

        }


        if ($request->has('returned_at') && $request->input('returned_at') == null) {

            //  dd($rent->artwork->isAvailable());
            if ($rent->artwork->isAvailable()) {
                $rent->update($request->only('returned_at'));
            } else {
                throw new \Exception('Kunstwerk niet beschikbaar');

            }
        } else {
            $rent->update($attributes);
        }

        //check if available at


        return Rent::findOrFail($rent->id);
    }

}
