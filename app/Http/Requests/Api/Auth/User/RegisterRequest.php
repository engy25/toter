<?php

namespace App\Http\Requests\Api\Auth\User;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Requests\Api\ApiMasterRequest;

class RegisterRequest extends ApiMasterRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules()
  {

    //$phone='required|regex:/(1)[1-9]/|not_regex:/[a-z]/|min:9';
    $phoneRegex = '/^[1]{1}[0-9]{9}$/';
    $phone = 'regex:/^[^0]/';
    return [
      'phone' => 'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone',
      'country_code' => 'required|exists:countries,country_code',
      'fname' => 'required|string|between:3,40',
      'terms' => 'required|in:1',
      'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
      'confirm_password' => 'required|same:password',
      'email'=>'required|email|max:55|unique:users,email'
      // 'provider' => 'nullable|in:facebook,google,apple',
      // 'provider_id' => 'nullable|string|between:2,255',




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
