<?php

namespace App\Http\Requests\API\Profile;

use App\Helpers\JsonFormRequest;

class ChangePasswordeRequest extends JsonFormRequest
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
            'old_password'      => 'required|min:8',
            'password'          => 'confirmed|required|min:8',
        ];
    }
}
