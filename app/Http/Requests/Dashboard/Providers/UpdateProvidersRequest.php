<?php

namespace App\Http\Requests\Dashboard\Providers;

use Illuminate\Foundation\Http\FormRequest;


class UpdateProvidersRequest extends FormRequest
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
            'provider_name'                     => 'required|string|max:150',
            'email'                             => 'required|email|unique:users,email,'.$this->provider->id.',id',
            'phone'                             => 'required|unique:users,phone,'.$this->provider->id.',id',
            'how_to_know_us'                    => "required|exists:know_us,id",
            'commercial_registration_number'    => "required|numeric",
            'tax_number'                        => "",
            'region'                            => "required|numeric|exists:areas,id",
            'city'                              => "required|numeric|exists:areas,id",
            'lat'                               => "required|numeric",
            'lng'                               => "required|numeric",
            'terms'                             => "sometimes",
            'vat'    => "required|numeric",
            'commission_price'    => "required|numeric",
            'categories'                        => "required|array",
            'categories.*'                      => "required|exists:categories,id",
            'factories'                         => 'required|array',
            'factories.*'                       => 'required|exists:car_country_factories,id',
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
