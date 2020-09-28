<?php

namespace App\Http\Controllers;

use App\Actions\Artwork\delete;
use App\Artist;
use App\Artwork;
use App\ArtworkUser;
use App\Http\Filter\ArtworkFilter;
use App\Http\Requests\StoreArtwork;
use App\Http\Requests\UpdateArtwork;
use App\Http\Resources\ArtworkCollection;
use App\Http\Resources\ArtworkDetailResource;
use App\Http\Resources\ArtworkResource;
use App\Http\Resources\IsSoldResource;
use App\NotifyArtworkAvailable;
use App\Services\ArtworkService;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ArtworkController extends Controller
{
    protected $artworkService;

    public function __construct(ArtworkService $artworkService)
    {
        $this->artworkService = $artworkService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArtworkFilter $filter, Request $request)
    {
        return $this->artworkService->index($filter, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtwork $request)
    {
        $file = $request->file('thumbnailurl');
        return new ArtworkResource($this->artworkService->store($request, $file));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Artwork $artwork
     * @return \Illuminate\Http\Response
     */
    public function show(Artwork $artwork)
    {

        return new ArtworkDetailResource($this->artworkService->show($artwork));
    }

    public function showImage(Artwork $artwork)
    {
        return Storage::download('public/img/' . $artwork->thumbnailurl);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Artwork $artwork
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtwork $request, Artwork $artwork)
    {
        return new ArtworkDetailResource($this->artworkService->update($request, $artwork));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Artwork $artwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artwork $artwork)
    {
        $deleteArtwork = new delete();
        try {
            $deleteArtwork->execute($artwork);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);

        }

        return response()->json('OK', 200);

    }


    public function sold(Request $request)
    {
        return IsSoldResource::colection(Artwork::get());
    }
}
