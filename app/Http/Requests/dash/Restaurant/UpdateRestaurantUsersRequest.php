<?php

namespace App\Http\Requests\dash\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantUsersRequest extends FormRequest
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

    $userId = $this->route()->parameter('restaurantuser')->id;


    return [
      'phone' => 'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone,' . $userId,
      'country' => 'required|exists:countries,country_code',
      'fname' => 'required|string|between:3,40',
      "store_id" => "required|exists:stores,id",
      'email' => 'required|string|email|max:255|unique:users,email,'.$userId,
      'password' => 'nullable|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',



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
