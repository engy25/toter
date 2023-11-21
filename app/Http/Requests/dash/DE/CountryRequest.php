<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
          'code' => 'required|string|max:3',
          'code2' => 'required|string|max:3',
          'name_en' => 'required|string|max:50',
          'name_ar' => 'required|string|max:50',
          'region_en' => 'required|string|max:50',
          'region_ar' => 'required|string|max:50',
          'localName_en' => 'required|string|max:50',
          'localName_ar' => 'required|string|max:50',
          'governmentForm_en' => 'required|string|max:50',
          'governmentForm_ar' => 'required|string|max:50',
          'HeadOfState' => 'nullable|string|max:50',
          'capital' => 'nullable|string|max:50',
          'continent' => 'required|string|in:Asia,North America,South America,Antarctica,Europe,Australia,Africa',
          'IndepYear' => 'nullable|integer|min:1900|max:' . date('Y'), // Assuming IndepYear should be a valid year
          'population' => 'nullable|integer|min:0',
          'surfaceArea' =>  'nullable|regex:/^\d{1,8}(\.\d{1,2})?$/',
          'lifeExpectancy' => 'nullable|regex:/^\d{1,8}(\.\d{1,2})?$/',
          'GNP' => 'nullable|regex:/^\d{1,8}(\.\d{1,2})?$/',
          'GNPOld' => 'nullable|regex:/^\d{1,8}(\.\d{1,2})?$/',
          'currency_id' => 'required|exists:currencies,id',
        ];
    }
}
