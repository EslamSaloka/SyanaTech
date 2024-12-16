<?php

namespace App\Http\Requests\Dashboard\Intros;

use Illuminate\Foundation\Http\FormRequest;


class UpdateIntrosRequest extends FormRequest
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
            'description',
        ];
        $return = [
            'image'
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
           'description'                 => 'required',
        ];
        $rules = [
            'image'                => 'sometimes|image|mimes:png,jpg',
        ];
        foreach(config('laravellocalization.supportedLocales') as $key=>$value) {
            foreach($lang as $K=>$V) {
                $rules[$key.".".$K] = $V;
            }
        }
        return $rules;
    }
}
