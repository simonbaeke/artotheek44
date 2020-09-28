<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 13/11/18
 * Time: 21:53
 */

namespace App\Services;


use App\Artwork;
use App\Http\Filter\ArtworkFilter;
use App\Http\Resources\ArtworkResource;
use App\Http\Resources\AvailableResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ArtworkService
{
    protected $artWork;

    public function __construct(Artwork $artwork)
    {
        $this->artWork = $artwork;
    }

    public function index(ArtworkFilter $filter, Request $request)
    {
        if ($request->has('available')) {
            return AvailableResource::collection($this->artWork->filter($filter)->inRandomOrder()->with(['artist', 'type', 'rents', 'reservations'])->get());
        }

        return ArtworkResource::collection($this->artWork->filter($filter)->inRandomOrder()->with(['artist', 'type', 'rents', 'reservations'])->get());

    }

    public function store(Request $request, $file)
    {
        return Artwork::create([
            'name' => $request->input('name'),
            'type_id' => $request->input('type_id'),
            'artist_id' => $request->input('artist_id'),
            'thumbnailurl' => $this->saveImage($file),
            'length' => $request->input('length'),
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'price' => $request->input('price'),
            'code' => str_pad(preg_replace('/\s+/', '', $request->input('code')), 3, "0", STR_PAD_LEFT),
            'forsale' => ($request->input('forsale')) == 'true'
        ]);
    }

    public function show(Artwork $artwork)
    {
        return $artwork;
    }

    public function update(Request $request, Artwork $artwork)
    {

        if ($request->has('thumbnailurl')) {

            Storage::delete('public/img/thumbnail/' . $artwork->thumbnailurl);
            Storage::delete('public/img/' . $artwork->thumbnailurl);
            $artwork->update(['thumbnailurl' => $this->saveImage($request->file('thumbnailurl'))]);
        }

        $artwork->update([
            'name' => $request->input('name'),
            'type_id' => $request->input('type_id'),
            'artist_id' => $request->input('artist_id'),
            'length' => $request->input('length'),
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'price' => $request->input('price'),
            'code' => str_pad(preg_replace('/\s+/', '', $request->input('code')), 3, "0", STR_PAD_LEFT),
            'forsale' => ($request->input('forsale')) == 'true'
        ]);

        return $artwork;
    }

    protected function saveImage($file)
    {
        $filename = basename(Storage::put('public/img', $file));
        $full = Image::make(Storage::get('public/img/' . $filename))->stream()->__toString();
        Storage::put('public/img/' . $filename, $full);

        //thumbnail
        try {
            $img = Image::make(Storage::get('public/img/' . $filename))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream('jpg', 90)->__toString();

            Storage::put('public/img/thumbnail/' . $filename, $img);

        } catch (\Exception $e) {
            throw new \Exception($e);
        }
        return $filename;

    }

}
