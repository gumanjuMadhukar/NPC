<?php

namespace App\Http\Requests\Operator\Fee;

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
            'level_id' => 'required',
            'amount' => 'required',
            'college_type' =>'required',
            'description' => 'sometimes',
            'status' => 'sometimes',
        ];
    }
}
