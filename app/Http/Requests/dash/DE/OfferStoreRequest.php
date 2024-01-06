<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class OfferStoreRequest extends FormRequest
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
          'name_en' => 'required|string|max:30|unique:offer_tanslations,name',
          'name_ar' => 'required|string|max:30|unique:offer_tanslations,name',
          'description_en' => 'required|string|max:500',
          'description_ar' => 'required|string|max:500',
          'title_en' => 'required|string|max:500',
          'title_ar' => 'required|string|max:500',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'store_id'=>'required|exists:stores,id',
          'tier_id'=>'required|exists:tiers,id',
          'from_date' => 'required|date|after_or_equal:today',
          'to_date' => 'required|date|after:from_date',
          'discount_percentage' => 'numeric|required|integer|max:100',
          'saveup_price' => 'numeric|required|max:9999999999999999999999999999.99',
          'order_counts' => 'numeric|integer|required|digits_between:1,11|max:99999999999',
          'required_points' => 'numeric|integer|required|min:1|max:9223372036854775807',
          'earned_points' => 'numeric|integer|required|min:1|max:9223372036854775807',
         'featured'=>'nullable'



        ];
    }
}
