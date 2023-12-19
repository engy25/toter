<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateStoreRequest extends FormRequest
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
    $storeTranslationId = $this->route('store');


    return [
      'name_en' => [
        'required',
        'string',
        'max:255',
        Rule::unique('store_translations', 'name')->ignore($storeTranslationId->id, 'store_id'),
      ],
      'name_ar' => [
        'required',
        'string',
        'max:255',
        Rule::unique('store_translations', 'name')->ignore($storeTranslationId->id, 'store_id'),
      ],
      'description_en' => 'required|string|max:500',
      'description_ar' => 'required|string|max:500',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'address' => 'required|string|max:500',
      'section_id' => 'required|exists:sections,id',
      'sub_section_id' => 'required|exists:subsections,id',
      'delivery_time' => 'required|string|max:255',
    ];
  }

}
