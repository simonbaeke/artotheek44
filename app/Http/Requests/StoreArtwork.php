<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class StoreArtwork extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if ($request->has('code')) {
            Input::merge(array('code' => str_pad(preg_replace('/\s+/', '', $request->input('code')), 3, "0", STR_PAD_LEFT),));
        }

        return [
            'type_id' => 'required|numeric',
            'thumbnailurl' => 'required|image|max:2048',
            'artist_id' => 'required',
            'name' => 'required',
            'width' => 'required',
            'length' => 'required',
            'height' => 'required',
            'forsale' => 'required',
            'price' => 'required_if:forsale,true',
            'code' => ['required', Rule::unique('artworks', 'code')->where(function ($query) use ($request) {
                $query
                    ->where('artist_id', $request->input('artist_id'))
                    ->where('type_id', $request->input('type_id'));
            })]
        ];
    }
}
