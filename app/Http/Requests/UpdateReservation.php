<?php

namespace App\Http\Requests;

use App\Reservation;
use App\Subscription;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateReservation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Reservation $reservation)
    {

        if (auth('api')->check())
        {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'active' => 'required',
        ];
    }
}
