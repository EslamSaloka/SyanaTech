<?php

namespace App\Http\Requests\Dashboard\Providers;

use Illuminate\Foundation\Http\FormRequest;


class CreateProvidersRequest extends FormRequest
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
            'provider_name'      => 'required|string|max:150',
            'email'              => 'required|email|unique:users,email',
            'phone'              => 'required|unique:users,phone',
            'password'           => 'required|string|min:8',
            'avatar'             => 'required|image',
            'how_to_know_us'     => "required|exists:know_us,id",
            'commercial_registration_number'    => "required",
            'tax_number'    => "",
            'region'    => "required",
            'city'    => "required",
            'lat'    => "required",
            'lng'    => "required",
            'terms'    => "required",
            'vat'    => "required|numeric",
            'commission_price'    => "required|numeric",
            'categories'      => "required|array",
            'categories.*'    => "required|exists:categories,id",
            'factories'       => 'required|array',
            'factories.*'     => 'required|exists:car_country_factories,id',
        ];
    }
}
