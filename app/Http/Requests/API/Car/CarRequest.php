<?php

namespace App\Http\Requests\API\Car;

use App\Helpers\JsonFormRequest;

class CarRequest extends JsonFormRequest
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
        return [
            'color_id'  => "required|numeric|exists:colors,id",
            'make'      => "required|numeric|exists:car_modals,id",
            'models'    => "required|numeric|exists:car_modals,id",
            'year'      => "required|numeric",
            'vin'       => [
                "nullable",
                "regex:/^(?=.*[0-9])(?=.*[A-z])[0-9A-z-]{17}$/"
            ],
            'car_country_factory_id'    => "required|exists:car_country_factories,id",
        ];
    }
}
