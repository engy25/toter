<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CompanyDistrictRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           "from_id"=>"required|exists:districts,id",
           "to_id" => [
            "required",
            "exists:districts,id",
            Rule::unique('company_districts')->where(function ($query) {
                return $query->where('from_id', $this->from_id)->where('to_id', $this->to_id);
            }),
        ],
           "delivery_charge"=>'numeric|max:999999999999999999999999999.99|required',
        ];
    }
}
