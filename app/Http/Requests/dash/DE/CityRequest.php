<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
          "name_en" => 'required|string|max:30|min:3|unique:cities,name_en',
          "name_ar" => 'required|string|max:30|min:3|unique:cities,name_ar',
          "district_en" => 'required|string|max:30|min:3',
          "district_ar" => 'required|string|max:30|min:3',
          'population' => 'nullable|integer|digits_between:1,11', // Validate population as an integer with max length 11
          "CountryCode" => 'required|string|max:30|min:3',
          'country_id' => 'required|exists:countries,id'

        ];
    }
}
