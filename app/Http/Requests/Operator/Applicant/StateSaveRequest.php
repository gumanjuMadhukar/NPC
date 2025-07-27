<?php

namespace App\Http\Requests\Operator\Applicant;
use App\Http\Requests\RestRequest;

class StateSaveRequest extends RestRequest
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
            'state' => 'required',
            'id' => 'required|exists:exam_applies,id',
        ];
    }
}
