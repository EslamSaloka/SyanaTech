<?php

namespace App\Http\Requests\Dashboard\Banks;

use Illuminate\Foundation\Http\FormRequest;


class CreateBanksRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    public function attributes() {
        $lang = [
            'bank_name',
            'account_name',
        ];
        $return = [
            'iban',
            'account_number',
            'image',
        ];
        foreach(config('laravellocalization.supportedLocales') as $key=>$value) {
            foreach($lang as $V) {
                $return[$key.".".$V] = __($key.".".$V);
            }
        }
        return $return;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $lang = [
           'bank_name'     => 'required|string|max:150',
           'account_name'  => 'required|string|max:150',
        ];
        $rules = [
            'iban'              => 'required',
            'account_number'    => 'required',
            'image'             => 'required|image|mimes:png,jpg',
        ];
        foreach(config('laravellocalization.supportedLocales') as $key=>$value) {
            foreach($lang as $K=>$V) {
                $rules[$key.".".$K] = $V;
            }
        }
        return $rules;
    }
}
