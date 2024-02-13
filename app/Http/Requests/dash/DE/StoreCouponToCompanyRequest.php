<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponToCompanyRequest extends FormRequest
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
        'max_user_used_code' => 'numeric|integer|required|digits_between:1,11|max:99999999999',


      ];

      // Add specific rules based on the discount_type
      if ($this->input('type') === 'discount') {
        $rules['discount_percentage'] = 'required|integer|max:100';
      } else {
        $rules['price'] = 'max:999999999999999999999999999.99|required|numeric';
      }

      return $rules;
    }
  }
