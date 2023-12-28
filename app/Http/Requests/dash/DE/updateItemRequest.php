<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class updateItemRequest extends FormRequest
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
    $itemId = $this->route()->parameter('item')->id;

    return [
      'upname_en' => 'required|string|max:30|unique:item_translations,name,' . $itemId,
      'upname_ar' => 'required|string|max:30|unique:item_translations,name,' . $itemId,
      'updescription_en' => 'required|string|max:500',
      'updescription_ar' => 'required|string|max:500',
      'upimage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'upprice' => 'numeric|max:9999999999999999999999999999.99|required',
      'upadded_value'=>'integer|max:11',
    ];
  }
}
