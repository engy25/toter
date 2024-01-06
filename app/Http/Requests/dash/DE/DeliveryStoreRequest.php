<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryStoreRequest extends FormRequest
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

    $phoneRegex = '/^[1]{1}[0-9]{9}$/';
    $phone = 'regex:/^[^0]/';
    return [
      'phone' => 'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone',
      'country' => 'required|exists:countries,country_code',
      'fname' => 'required|string|between:3,40',
      'lname' => 'required|string|between:3,40',
      'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
      'email' => 'required|email|max:55|unique:users,email',
      'image' => 'required|image|mimes:jpeg,png,jpg',
      'deliveries.*.day_id' => 'required|integer|exists:days,id|distinct',
      'deliveries.*.from_time' => 'required',
      'deliveries.*.to_time' => 'required|after:deliveries.*.from_time',
    ];
  }
  public function messages()
  {

    return [
      'password.regex' => trans('api.password-regex'),
      'phone.regex' => trans('api.phone.regex'),
      'deliveries.*.day_id.distinct' => 'Each day should be selected only once.',

    ];
  }
}
