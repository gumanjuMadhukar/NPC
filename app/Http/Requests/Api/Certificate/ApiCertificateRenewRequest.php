<?php

namespace App\Http\Requests\Api\ApiCertificateRenew;

use App\Http\Requests\RestRequest;

class CertificateRenewStoreRequest extends RestRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'level_id' => 'required|exists:levels,id',
            'program_id' => 'required|exists:programs,id',
            'cert_registration_number' => 'required|string',
            'voucher_image' => 'required|string',
            'status' => 'sometimes|in:pending,approved,rejected',
        ];
    }
}
