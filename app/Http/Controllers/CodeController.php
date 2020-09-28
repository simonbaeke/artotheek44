<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
use App\Artwork;
use App\Artist;

class CodeController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'artist_id' => 'required',
        ]);

        $type = str_pad(Type::find($request->input('type_id'))->type_code, 2, "0", STR_PAD_LEFT);


        $id = str_pad(Artwork::where('artist_id', $request->input('artist_id'))->
            where('type_id', $request->input('type_id'))->where('artist_id', $request->input('artist_id'))->max('code') + 1, 3, 0, STR_PAD_LEFT);

        $code = $type . " - " . Artist::find($request->input('artist_id'))->short . " - " . $id;

        return ['code' => $id, 'precode' => $type . " - " . Artist::find($request->input('artist_id'))->short];
    }
}
