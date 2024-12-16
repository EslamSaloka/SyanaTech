<?php

namespace App\Http\Requests\Dashboard\Cars;

use Illuminate\Foundation\Http\FormRequest;

class CarsRequest extends FormRequest
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
    public function rules()
    {
        $return = [
            'color_id'                  => "required|exists:colors,id",
            'car_country_factory_id'    => "required|exists:car_country_factories,id",
            'customer_id'               => "required|exists:users,id",
            'vin'       => [
                "required",
                "regex:/^(?=.*[0-9])(?=.*[A-z])[0-9A-z-]{17}$/"
            ],
        ];
        return $return;
    }
}
