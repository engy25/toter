<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueDayIds;

class StoreRequest extends FormRequest
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
      'name_en' => 'required|string|max:255|unique:store_translations,name',
      'name_ar' => 'required|string|max:255|unique:store_translations,name',
      'description_en' => 'required|string|max:500',
      'description_ar' => 'required|string|max:500',
      'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'address' => 'required|string|max:500',
      'section_id' => 'required|exists:sections,id',
      'sub_section_id' => 'required|exists:subsections,id',
      'delivery_time' => 'required|string|max:255',
      'weekhours' => ['required', 'array', new UniqueDayIds],

      'store_categories.*.name_en' => 'required|string|max:250',
      'store_categories.*.description_en' =>'required|string|max:500',
      'store_categories.*.name_ar' => 'required|string|max:250',
      'store_categories.*.description_ar' => 'required|string|max:500',

    ];
  }
}
