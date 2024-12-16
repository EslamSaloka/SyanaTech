<?php

namespace App\Http\Requests\API\Auth;

use App\Helpers\JsonFormRequest;

class CustomerRegisterRequest extends JsonFormRequest
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
            'first_name'        => 'required',
            'last_name'         => 'required',
            'phone'             => 'required',
            'email'             => 'required|email',
            'password'          => 'required|confirmed|min:8',
            'devices_token'     => 'required',
            'how_to_know_us'    => 'required|exists:know_us,id',
            // ========================== //
            'region'        => 'required|numeric|exists:areas,id',
            'city'          => 'required|numeric|exists:areas,id',
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
        ];
    }
}
