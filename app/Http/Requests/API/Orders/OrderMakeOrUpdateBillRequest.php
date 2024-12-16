<?php

namespace App\Http\Requests\API\Orders;

use App\Helpers\JsonFormRequest;

class OrderMakeOrUpdateBillRequest extends JsonFormRequest
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
            'sub_total'          => 'required',
            'vat'                => 'required',
            'commission_price'   => 'required',
            'total'              => 'required',
            'items'              => 'required|array',
            'items.*.name'       => 'required',
            'items.*.price'      => 'required',
        ];
    }
}
