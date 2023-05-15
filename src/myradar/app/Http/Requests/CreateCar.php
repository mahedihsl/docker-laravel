<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCar extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *sessions
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
            'name'      => 'required|min:3',
            'model'     => 'required|min:3',
            'reg_no'    => 'required|min:6',
            'user_id'   => 'required',
            'activation_key' => 'required|size:4',
            'type'      => 'required|min:1|max:3',
            'services'  => 'required|array',
        ];
    }
}
