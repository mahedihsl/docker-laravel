<?php

namespace App\Http\Requests;

use App\Service\Microservice\UserMicroservice;
use Illuminate\Foundation\Http\FormRequest;

class PaymentInitRequest extends FormRequest
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
            //
        ];
    }

    public function getApiUser()
    {
        $service = new UserMicroservice();
        $response = $service->getAuthUser($this->api_token);
        return $response['user'];
    }

    public function getAmount()
    {
        return intval($this->amount);
    }

    public function getTransactionId(): string
    {
        return uniqid('ssl-', true);
    }
}
