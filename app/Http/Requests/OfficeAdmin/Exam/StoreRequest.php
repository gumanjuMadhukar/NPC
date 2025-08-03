<?php

namespace App\Http\Requests\OfficeAdmin\Exam;

use App\Http\Requests\RestRequest;

class StoreRequest extends RestRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'integer|nullable',
            'name' => 'required',
            'exam_number' => 'required',
            'name_nep' => 'sometimes',
            'opening_date' => 'required',
            'closing_date' => 'required',
            'description' => 'sometimes',
            'status' => 'sometimes',
        ];
    }
}
