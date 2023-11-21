<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class AboutUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "description_en"=>'required|string|max:5000',
            "description_ar"=>'required|string|max:5000',
            "name_en"=>"required|string|max:200",
            "name_ar"=>"required|string|max:200",

        ];
    }
}
