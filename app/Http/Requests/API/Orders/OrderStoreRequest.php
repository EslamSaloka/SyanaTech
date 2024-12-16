<?php

namespace App\Http\Requests\API\Orders;

use App\Helpers\JsonFormRequest;

class OrderStoreRequest extends JsonFormRequest
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
            "region_id"             => 'required|exists:areas,id',
            "city_id"               => 'required|exists:areas,id',
            "car_id"                => 'required|exists:cars,id',
            "category_id"           => 'required|exists:categories,id',
            "provider_id"           => 'sometimes|exists:users,id',
            "address_name"          => 'required',
            "location_name"         => 'required',
            "lat"                   => 'required',
            "lng"                   => 'required',
            "order_place"           => 'required|in:in-location,in-center',
            "description"           => 'sometimes',
            "images"                => 'sometimes|array',
            "images.*"              => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
