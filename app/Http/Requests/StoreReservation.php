<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'artwork_id' => 'required'
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException(
            'Log in of registreer 
            en maak dat je dan ook ingelogd bent, of het zal
            ook niet gaan om een reservering aan te maken');
    }
}
