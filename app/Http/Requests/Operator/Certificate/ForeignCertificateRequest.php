<?php

namespace App\Http\Requests\Operator\Certificate;
use App\Http\Requests\RestRequest;

class ForeignCertificateRequest extends RestRequest
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
            'id' => 'sometimes',
            'profile_picture' => 'sometimes',
            'decision_date' => 'required',
            'name' => 'required',
            'dob' => 'required',
            'ward_no' => 'required',
            'municipality' => 'required',
            'district' => 'required',
            'province' => 'required',
            'program_id' => 'required',
            'level_id' => 'required',
            'cert_registration_number' => 'sometimes',
            'registrar' => 'required',
            'issued_date' => 'required',
            'issued_year' => 'sometimes',
            'user_info_id' => 'sometimes',
            'program_code' => 'required',
            'board_university' => 'required',
            'passed_year' => 'required',
            'duration' => 'required',
        ];
    }
}
