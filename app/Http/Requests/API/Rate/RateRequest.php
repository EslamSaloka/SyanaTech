<?php

namespace App\Http\Requests\API\Rate;

use App\Helpers\JsonFormRequest;

class RateRequest extends JsonFormRequest
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
            'rate'          => 'required',
            'message'       => 'required',
        ];
    }
}
