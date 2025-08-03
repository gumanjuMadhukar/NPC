<?php

namespace App\Http\Requests\OfficeAdmin\Municipality;
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
            'district_id' => 'required',
            'name' => 'required',
            'status' => 'sometimes',
        ];
    }
}
