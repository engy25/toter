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
      'country_id' => 'required|exists:countries,id',


      'name_en' => 'required|min:3|max:30|unique:city_translations,name_en',

      "name_ar" => 'required|min:3|max:30|unique:city_translations,name_en',
    ];

  }
}
