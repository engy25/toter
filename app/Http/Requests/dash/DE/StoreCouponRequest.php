<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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

    $rules = [

      'code' => 'required|string|max:30|unique:coupons,code',
      'expire_date' => 'required|date|after:now',
      'discount_type' => 'required|in:percentage,price',
      'discount_value' => 'required|numeric',
      'store_id' => 'required|exists:stores,id',
      'max_user_used_code' => 'numeric|integer|required|digits_between:1,11|max:99999999999',
      'items.*'=>"required|exists:items,id"
    ];

    // Add specific rules based on the discount_type
    if ($this->input('discount_type') === 'percentage') {
      $rules['discount_value'] .= '|integer|max:100';
    } else {
      $rules['discount_value'] .= '|max:999999999999999999999999999.99|required';
    }

    return $rules;
  }
}
