<?php

namespace App\Http\Requests\Dashboard\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'first_name'    =>  'required|min:4',
            'last_name'     =>  'required|min:4',
            'email'         =>  'required|email|unique:users,email,'.\Auth::user()->id,
        ];

        if(request()->has('avatar') && !is_null(request('avatar'))) {
            $return['avatar'] = 'required|image';
        }
        if(request()->has('password') && !is_null(request('password'))) {
            $return['password'] = 'required||min:8';
        }
        return $return;
    }
}
