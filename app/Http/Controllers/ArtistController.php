<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Http\Requests\StoreArtist;
use App\Http\Resources\ArtistDetailResource;
use App\Http\Resources\ArtistResource;
use App\Services\ArtistService;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    protected $artistService;

    public function __construct(ArtistService $artistService)
    {
        $this->artistService = $artistService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ArtistResource::collection(Artist::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtist $request)
    {
        return new ArtistResource($this->artistService->store($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Artist $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        return new ArtistDetailResource($artist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Artist $artist
     * @return \Illuminate\Http\Response
     */
    public function edit(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Artist $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artist $artist)
    {
        $artist->update($request->all());
        return new ArtistResource($artist);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Artist $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        //
    }
}
