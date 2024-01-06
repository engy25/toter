<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
          'code' => 'required|string|max:30|unique:coupons,code',
          'expire_date' => 'required|date|after:now',
          'discount_percentage' => 'numeric|required|integer|max:100',
          'store_id'=>'required|exists:stores,id',
          'max_user_used_code'=>'numeric|integer|required|digits_between:1,11|max:99999999999',

        ];
    }
}
