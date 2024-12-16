<?php

namespace App\Http\Requests\API\Orders;

use App\Helpers\JsonFormRequest;

class OrderRateRequest extends JsonFormRequest
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
            'order_id' => "required|exists:orders,id",
            'rate'     => 'required',
            'message'  => 'sometimes',
        ];
    }
}
