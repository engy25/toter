<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends ApiMasterRequest
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
    return [
      'title' => 'required|in:المنزل,عمل,امي,غير',
      'building' => 'required|min:3,max:200',
      'street' => 'required|min:3,max:200',
      'apartment' => 'required|min:3,max:200',
      'phone' => 'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone',
      'country_code' => 'required|exists:countries,country_code',
      'default' => 'required|in:1,0',
      'lat' => 'required|numeric',
      'lng' => 'required|numeric',
      'instructions' => 'nullable|min:3,max:200',
    ];
  }
}
