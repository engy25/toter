<?php

namespace App\Http\Requests\Api\Auth\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterSocialRequest extends ApiMasterRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return false;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'phone' => 'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone',
      'country_code' => 'required|exists:countries,country_code',
      'provider' => 'required|in:facebook,google',
      'provider_id' => 'required|string|between:2,255',
      'type' => 'required|in:ios,android',
      'device_token' => 'required',
    ];
  }
}
