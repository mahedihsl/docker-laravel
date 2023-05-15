<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateZone extends FormRequest
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
            'name'      => 'required|min:3',
            'lat'       => 'required|numeric',
            'lng'       => 'required|numeric',
            'radius'    => 'required|numeric',
            'user_id'   => 'required',
        ];
    }
}
