<?php

namespace App\Http\Requests\Operator\Applicant;
use App\Http\Requests\RestRequest;

class PersonalRequest extends RestRequest
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
            'id' =>'required',
            'profile_picture' => 'required',
            'level' => 'required',
            'first_name' => 'required',
            'middle_name' => 'sometimes',
            'last_name' => 'required',
            'first_name_nep' => 'required',
            'middle_name_nep' => 'sometimes',
            'last_name_nep' => 'required',
            'dob_eng' => 'required',
            'dob_nep' => 'required',
            'sex' => 'required',
            'marital_status' => 'required',
            'ethinic' => 'required',
            'citizenship_number' => 'required',
            'citizenship_issue_date' => 'required',
            'citizenship_issue_district' => 'required',
            'citizenship_front' => 'required',
            'citizenship_back' => 'required',
            'signature_image' => 'required',
            'province' => 'required',
            'district' => 'required',
            'municipality' => 'required',
            'ward_no' => 'required|integer',
        ];
    }
	
	 public function messages()
    {
        return [
            'dob_nep.required' => __('Date of Birth(B.S) is required'),
            'dob_eng.required' => __('Date of Birth(A.D) is required'),
            'sex.required' => __('Gender is required'),
        ];
    }
}
