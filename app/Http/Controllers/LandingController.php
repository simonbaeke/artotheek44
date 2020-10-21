<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Json;


class LandingController extends Controller
{
    public function read(Request $request){
        return  Storage::download('data/data.json');
    }

    public function write(Request $request){

        return Storage::put('data/data.json',$request->data);
    }
}
