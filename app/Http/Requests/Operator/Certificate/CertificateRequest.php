<?php

namespace App\Http\Requests\Operator\Certificate;
use App\Http\Requests\RestRequest;

class CertificateRequest extends RestRequest
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
            'id' => 'required|exists:certificates,id',
            'cert_registration_number' => 'required',
            'program_id' => 'required',
            'level_id' => 'required',
            'registrar' => 'required',
            'decision_date' => 'sometimes',
            'issued_year' => 'sometimes',
            'issued_date' => 'required',
            'user_info_id' => 'required',
            'profile_picture' => 'sometimes',
            'first_name' => 'required',
            'middle_name' => 'sometimes',
            'last_name' => 'required',
            'dob_nep' => 'required',
            'ward_no' => 'required',
            'municipality_id' => 'required',
            'district_id' => 'required',
            'province_id' => 'required',
            'board_university' => 'sometimes',

            'qualification' => 'sometimes',
        ];
    }
}
