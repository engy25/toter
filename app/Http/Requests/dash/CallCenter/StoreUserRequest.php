<?php

namespace App\Http\Requests\dash\CallCenter;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        // 'building'=> 'required|string|between:3,200',
        // 'street'=> 'required|string|between:3,200',
        // 'apartment'=> 'required|string|between:3,200',
        // 'instructions'=> 'nullable|string|between:3,200',
        // 'district_id'=>'required|exists:districts,id',
        // 'city_id'=>"required|exists:cities,id"


      ];
    }
    public function messages()
    {

      return [

        'phone.regex' => trans('api.phone.regex'),

      ];
    }
  }
