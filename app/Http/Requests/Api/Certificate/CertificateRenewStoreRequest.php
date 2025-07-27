<?php

namespace App\Http\Requests\Api\Certificate;

use App\Http\Requests\RestRequest;

class CertificateRenewStoreRequest extends RestRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id'                  => 'required|integer|exists:users,id',
            'level_id'                 => 'required|integer|exists:levels,id',
            'program_id'              => 'required|integer|exists:programs,id',
            'cert_registration_number' => 'required|string|max:255',
            'transaction_id'           => 'required|string|unique:certificate_renew_requests,transaction_id',
            'txnId'                    => 'nullable|string|max:255',
            'tidx'                     => 'nullable|string|max:255',
            'amount'                   => 'required|integer|min:0',
            'total_amount'             => 'nullable|integer|min:0',
            'status'                   => 'nullable|string',
            'cert_status'              => 'nullable|string',
            'purchase_order_name'      => 'nullable|string|max:255',
            'purchase_order_id'        => 'nullable|string|max:255',
            'mobile'                   => 'nullable|string|max:20',
            'voucher_image'            => 'nullable|file|mimes:jpg,png,jpeg,gif,pdf|max:2048',
        ];
    }

    /**
     * Customize the validation error messages.
     */
    public function messages()
    {
        return [
            'user_id.required'                  => 'User ID is required.',
            'level_id.required'                 => 'Level ID is required.',
            'program_id.required'               => 'Program ID is required.',
            'cert_registration_number.required' => 'Certificate registration number is required.',
            'transaction_id.required'           => 'Transaction ID is required.',
            'transaction_id.unique'             => 'This transaction ID has already been used.',
            'amount.required'                   => 'Amount is required.',
            'amount.numeric'                    => 'Amount must be a number.',
            'status.in'                         => 'Status must be one of: pending, approved, or rejected.',
            'cert_status.in'                    => 'Certificate status must be one of: active, inactive, or expired.',
            'voucher_image.required'            => 'Voucher image is required.',
            'voucher_image.mimes'               => 'Voucher must be a JPG, PNG, JPEG, GIF, or PDF.',
            'voucher_image.max'                 => 'Voucher must not exceed 2MB in size.',
        ];
    }
}
