<?php

namespace App\Http\Requests\Api\OnlinePayment;

use App\Http\Requests\RestRequest;

class FindUserRequest extends RestRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cert_registration_number' => 'required|string',
        ];
    }
}
