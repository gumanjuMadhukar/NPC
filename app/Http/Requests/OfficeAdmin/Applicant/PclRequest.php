<?php

namespace App\Http\Requests\OfficeAdmin\Applicant;

use App\Http\Requests\RestRequest;

class PclRequest extends RestRequest
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
            'level_id' => 'required',
            'college_type' => 'sometimes',
            'college_name' => (isset($this->college_type) && $this->college_type == 'nepal') ? 'required' : 'sometimes',
            'international_college_name' => ((isset($this->college_type) && $this->college_type == 'nepal' && isset($this->board_university) && $this->board_university == 'PCL') || ($this->id > 0)) ? 'sometimes' : 'required',
            'admission_year' => 'required|integer',
            'passed_year' => 'required|integer',
            'board_university' => 'required',
            'registration_number' => 'required',
            'transcript_image' => 'required',
            'transcript_bac_1' => 'sometimes',
            'transcript_bac_2' => 'sometimes',
            'provisional_image' => 'required',
            'character_image' => 'required',
            'equivalence_certificate' => 'sometimes',
            'council_registration_certificate' => 'sometimes',
            'ojt_pcl_community_1_image' => 'sometimes',
            'ojt_pcl_community_2_image' => 'sometimes',
            'noc_image' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'international_college_name.required' => 'College name is required'
        ];
    }
}
