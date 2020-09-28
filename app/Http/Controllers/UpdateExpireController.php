<?php

namespace App\Http\Controllers;

use App\Actions\Expire\Create;
use App\Expire;
use App\Http\Resources\ExpireResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateExpireController extends Controller
{
    public function __invoke(Request $request)
    {


        $request->validate([
            'expirable_id' => 'required',
            'expirable_type' => 'required',
            'date' => 'required',
        ]);

        $expire = Expire::where('expirable_id', $request->input('expirable_id'))
            ->where('expirable_type', $request->input('expirable_type'))
            ->orderBy('id', 'desc')
            ->first();

        if ($expire) {
            $expire->update([
                'date' => $request->input('date'),
                'updated_at' => Carbon::now()
            ]);

            $expire->save();
            return new ExpireResource($expire);
        }

        if (!$expire) {


             try {
                $expire = new Expire([
                    'expirable_type' => $request->input('expirable_type'),
                    'date' => $request->input('date'),
                    'expirable_id' => $request->input('expirable_id')]);

                $expire->save();
                return new ExpireResource($expire) ;
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 400);
            }


        }

        return response()->json(['message' => 'Datum niet aangepast'], 400);


    }
}
