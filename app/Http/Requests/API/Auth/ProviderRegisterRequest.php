<?php

namespace App\Http\Requests\API\Auth;

use App\Helpers\JsonFormRequest;

class ProviderRegisterRequest extends JsonFormRequest
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
            'provider_name'        => 'required',
            // 'last_name'         => 'required',
            'phone'             => 'required',
            'email'             => 'required|email',
            'password'          => 'required|confirmed|min:8',
            'devices_token'     => 'required',
            'how_to_know_us'    => 'required|exists:know_us,id',
            'commercial_registration_number'=> 'required',
            'tax_number'        => '',
            'region'            => 'required',
            'city'              => 'required',
            'lat'               => 'required',
            'lng'               => 'required',
            'categories'                        => 'required|array',
            'categories.*'                        => 'required|exists:categories,id',
            'carCountryFactories'               => 'required|array',
            'carCountryFactories.*'               => 'required|exists:car_country_factories,id',
        ];
    }
}
