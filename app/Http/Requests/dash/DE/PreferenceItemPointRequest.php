<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class PreferenceItemPointRequest extends FormRequest
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
          "name_en" => 'required|string|max:30|min:3|unique:preference_translations,name',
          "name_ar" => 'required|string|max:30|min:3|unique:preference_translations,name',
        ];
    }
}
