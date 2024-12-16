<?php

namespace App\Http\Requests\API\Auth;

use App\Helpers\JsonFormRequest;

class LoginRequest extends JsonFormRequest
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
            'phone'         => 'required',
            'password'      => 'required|min:8',
            'devices_token'     => 'required',
        ];
    }
}
