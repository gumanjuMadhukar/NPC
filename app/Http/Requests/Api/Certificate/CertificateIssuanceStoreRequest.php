<?php

namespace App\Http\Requests\Api\Certificate;

use App\Http\Requests\RestRequest;

class CertificateIssuanceStoreRequest extends RestRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'cert_registration_number' => 'required|string|unique:certificates,cert_registration_number',
            'program_id' => 'required|integer',
            'level_id' => 'required|integer',
            'voucher_image' => 'nullable|file|mimes:jpg,png,jpeg,gif|max:1024',
            // You can add 'transaction_id' => 'required|string' if payment gateway is used
        ];
    }
}
