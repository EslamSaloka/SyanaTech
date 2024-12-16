<?php

namespace App\Http\Requests\Dashboard\Customers;

use Illuminate\Foundation\Http\FormRequest;


class UpdateCustomersRequest extends FormRequest
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
        $rules = [
            'first_name'    => 'required|string|max:150',
            'last_name'     => 'required|string|max:150',
            'email'         => 'required|email|unique:users,email,'.$this->customer->id.',id',
            'phone'         => 'required|unique:users,phone,'.$this->customer->id.',id',
            'how_to_know_us'     => "required|exists:know_us,id",
        ];
        if(request()->has('password') && request()->password != null) {
            $rules['password'] = 'required|string|min:8';
        }
        if(request()->hasFile('avatar')) {
            $rules['avatar'] = 'required|image';
        }
        return $rules;
    }
}
