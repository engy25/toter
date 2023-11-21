<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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
    public function rules(): array
    {
      $cityId = $this->route()->parameter('city');
      return [
          "up_name_en" => 'nullable|string|max:30|min:3|unique:cities,name_en,' . $cityId,
          "up_name_ar" => 'nullable|string|max:30|min:3|unique:cities,name_ar,' . $cityId,
          "up_district_en" => 'nullable|string|max:30|min:3',
          "up_district_ar" => 'nullable|string|max:30|min:3',
          "up_population" => 'nullable|integer|max:30|min:3',
          "up_CountryCode" => 'nullable|string|max:30|min:3',

      ];
    }
}
