<?php

namespace App\Http\Requests\API\Profile;

use App\Helpers\JsonFormRequest;

class ChangePhoneRequest extends JsonFormRequest
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
            'password'   => 'required|min:8',
            'phone'      => 'required|unique:users,phone,'.\Auth::user()->id,
        ];
    }
}
