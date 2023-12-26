<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class districtRequest extends FormRequest
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
            "city_id"=>"required|exists:cities,id",
            "name_en"=>"required|min:3|max:30|unique:district_translations,name",
            "name_ar"=>"required|min:3|max:30|unique:district_translations,name",
        ];
    }
}
