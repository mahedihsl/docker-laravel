<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
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
            'current' => 'required',
            'new' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'new.required' => 'Password can not be empty',
            'new.confirmed' => "Your Passwords don't match",
        ];
    }

    public function success()
    {
        return 'Password changed';
    }

    public function failed()
    {
        return 'Current password is not correct';
    }
}
