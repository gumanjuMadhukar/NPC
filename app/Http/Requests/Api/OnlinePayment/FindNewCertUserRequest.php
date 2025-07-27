<?php

namespace App\Http\Requests\Api\OnlinePayment;

use App\Http\Requests\RestRequest;

class FindNewCertUserRequest extends RestRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'symbol_number' => 'required|string',
        ];
    }
}
