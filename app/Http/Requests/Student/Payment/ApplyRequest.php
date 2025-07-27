<?php

namespace App\Http\Requests\Student\Exam;
use App\Http\Requests\RestRequest;

class ApplyRequest extends RestRequest
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
            "exam_id" => "sometimes",
            "level" => "required",
            "program" => "required",
            "voucher_image" => "required",
        ];
    }
}
