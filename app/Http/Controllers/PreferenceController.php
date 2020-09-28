<?php

namespace App\Http\Controllers;

use App\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PreferenceController extends Controller
{
    //

    public function setPreference(Request $request)
    {

        $request->validate([
            'key' => 'required',
            'value' => 'required|boolean',
        ]);
        if (Schema::hasColumn('preferences', $request->input('key'))) {



           $preference =  Preference::where('user_id', Auth()->user()->id)->first();
           $preference->update([$request->input('key') => $request->input('value')]);

            return $preference;
        }

    }

    public function show()
    {
        return Preference::where('user_id', Auth()->user()->id)->first();
    }
}
