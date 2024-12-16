<?php

namespace App\Http\Requests\API\Customer;

use App\Helpers\JsonFormRequest;

class SearchRequest extends JsonFormRequest
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
            'category_id'    => 'required',
            'search_by'      => 'required|in:near,top_rate',
            'lat'            => 'required_if:search_by,near',
            'lng'            => 'required_if:search_by,near',
        ];
    }
}
