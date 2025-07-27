<?php

namespace App\Http\Requests\Student\Profile;
use App\Http\Requests\RestRequest;

class ForeignPersonalRequest extends RestRequest
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
            'profile_picture' => 'required',
            'level_id' => 'required',
            'first_name' => 'required',
            'middle_name' => 'sometimes',
            'last_name' => 'required',
            'dob_eng' => 'required',
            'dob_nep' => 'required',
            'sex' => 'required',
            'marital_status' => 'required',
            'passport_number' => 'required',
            'passport_issue_date' => 'required',
            'passport_issue_country' => 'required',
            'passport_image_1' => 'required',
            'passport_image_2' => 'nullable',
            'passport_image_3' => 'nullable',

            'visa_image_1' => 'required',
            'visa_image_2' => 'nullable',
            'visa_image_3' => 'nullable',

            'signature_image' => 'required',

            'country' => 'nullable',
            'state_province_region' => 'nullable',
            'city_town' => 'nullable',
            'street_name' => 'nullable',
            'postal_zip_code' => 'nullable',

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
