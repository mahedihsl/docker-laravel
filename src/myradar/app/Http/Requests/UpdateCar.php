<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCar extends FormRequest
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
            'id'        => 'required',
            'name'      => 'required|min:3',
            'model'     => 'required|min:3',
            'reg_no'    => 'required|min:6',
            'type'      => 'required|min:1|max:3',
            'cng'       => 'required|min:1|max:4',
            'services'  => 'required|array',
        ];
    }
}
