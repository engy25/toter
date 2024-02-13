<?php

namespace App\Http\Requests\dash\CallCenter;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderAddressRequest extends FormRequest
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
      'district_id' => 'required|exists:districts,id',
      'city_id' => "required|exists:cities,id",
      'building' => 'required|string|between:3,200',
      'street' => 'required|string|between:3,200',
      'apartment' => 'required|string|between:3,200',
      'instructions' => 'nullable|string|between:3,200',

    ];
  }
}
