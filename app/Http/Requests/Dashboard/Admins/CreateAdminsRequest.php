<?php

namespace App\Http\Requests\Dashboard\Admins;

use Illuminate\Foundation\Http\FormRequest;


class CreateAdminsRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'first_name'    => 'required|string|max:150',
            'last_name'     => 'required|string|max:150',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|unique:users,phone',
            'password'      => 'required|string|min:8',
            'avatar'        => 'sometimes|image|mimes:png,jpg',
        ];
    }
}
