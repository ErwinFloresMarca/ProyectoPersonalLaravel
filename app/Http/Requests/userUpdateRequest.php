<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userUpdateRequest extends FormRequest
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
            'nombres'=>'required|string|min:3',
            'apellidos'=>'required|string|min:3',
            'ci'=>'required|numeric|min:1000000|max:100000000',
            'telefono'=>'required|numeric|min:10000000|max:10000000',
            'email'=>'required|e-mail'
        ];
    }
}
