<?php

namespace App\Http\Controllers;

use App\Actions\Expire\Create;
use App\Expire;
use App\Http\Requests\ExpireRequest;
use App\Http\Resources\ExpireResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpireController extends Controller
{

    public function __construct()
    {
        //  $this->middleware(['role:superadmin'])->only('update');
        //  $this->middleware(['role:admin'])->only('create');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpireRequest $request)
    {
        $createExpire = new Create();

        try {
            $expire = $createExpire->execute($request->all());

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return new ExpireResource($expire);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ExpireResource(Expire::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Expire $expire)
    {


        $request->validate([

            'date' => 'required',
        ]);



        $expire->update([
            'date' => $request->input('date'),
            'updated_at' => Carbon::now()
        ]);



        //$expire->expirable->check();

        //datum kan niet aangepast worden tot er een betere oplossing is
        //wat is het probleem? ==> dat wanneer de datum met hoogste id aangepast wordt

      /*  if (Expire::where('expirable_type', $expire->expirable_type)
                ->where('expirable_id', $expire->expirable_id)
                ->count() > 1) {
            return response()->json(['message' => 'Datum kan niet aangepast worden'], 400);
        }*/


/*        Expire::where('expirable_type', $expire->expirable_type)
            ->where('expirable_id', $expire->expirable_id)
            ->where('id', '!=', $expire->id)
            ->whereDate('date', '>=', Carbon::parse($expire->date))
            ->update([
                'date' => Carbon::parse($expire->date)->subDay()
            ]);*/


        $expire->save();


        return new ExpireResource($expire);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expire $expire)
    {
        $oldexpire = Expire::where('expirable_type', $expire->expirable_type)
            ->where('expirable_id', $expire->expirable_id)
            ->orderBy('id', 'desc')->skip(1)->first();

        if ($oldexpire) {
            $expire->delete();
            return new ExpireResource($oldexpire);
        } else {
            return new ExpireResource($expire);
        }
    }
}
