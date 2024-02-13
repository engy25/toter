<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddOrderButlerRequest extends ApiMasterRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
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
      'from_address_id' => 'required|exists:addresses,id',
      'to_address_id' => 'required|exists:addresses,id',
      // 'district_id'=>'required|exists:company_Districts,id',
      'district_id'=>'required|exists:districts,id',

      'from_driver_instructions' => 'nullable|min:3|max:1000',
      'to_driver_instructions' => 'nullable|min:3|max:1000',
      'coupon_id' => 'nullable|exists:coupons,id',
      'payment_type' => 'required|in:cash,visa',
      'transaction_id' => 'required_if:payment_type,visa',
      'butler_id' => 'required|exists:butlers,id',
      'expected_cost'=>'nullable|numeric|digits_between:1,30|regex:/^\d{1,28}(\.\d{1,2})?$/',
      'expected_delivery_charge'=>'required|numeric|digits_between:1,30|regex:/^\d{1,28}(\.\d{1,2})?$/',

    ];

    if ($this->butler_id == 2) {
      $rules['items'] = 'required|array';
      $rules['item.*'] = 'required|string|min:3|max:1000';
      $rules['items.*image'] = 'mimes:jpeg,jpg,png,gif|nullable|max:1000';
     // $rules['expected_cost']= 'nullable|numeric|digits_between:1,30|regex:/^\d{1,28}(\.\d{1,2})?$/';
    } else {
      $rules["order"] = "required|string|min:4|max:65535";

    }

    return $rules;
  }
}
