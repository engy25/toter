<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryUpdateRequest extends FormRequest
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
    $deliveryId = $this->route()->parameter('delivery');
    return [
      'fname' => 'required|string|between:3,40',
      'lname' => 'required|string|between:3,40',
      'email' => 'required|email|max:55|unique:users,email,' . $deliveryId,
      'country' => 'required|exists:countries,country_code',
      'phone' => 'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone,' . $deliveryId,
      'password' => 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
      'upimage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];
  }
  public function messages()
  {

    return [
      'password.regex' => trans('api.password-regex'),
      'phone.regex' => trans('api.phone.regex'),


    ];
  }
}
