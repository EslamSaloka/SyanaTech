<?php

namespace App\Http\Requests\API\Profile;

use App\Helpers\JsonFormRequest;

class UpdateProfileRequest extends JsonFormRequest
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
            'first_name'    => 'sometimes',
            'last_name'     => 'sometimes',
            'phone'         => 'sometimes|unique:users,phone,'.\Auth::user()->id,
            'password'      => 'sometimes|min:8',
            'devices_token' => 'sometimes',
        ];
    }
}
