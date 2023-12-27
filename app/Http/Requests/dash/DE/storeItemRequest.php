<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class storeItemRequest extends FormRequest
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
          'name_en' => 'required|string|max:30|unique:item_translations,name',
          'name_ar' => 'required|string|max:30|unique:item_translations,name',
          'description_en' => 'required|string|max:500',
          'description_ar' => 'required|string|max:500',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'price'=>'numeric|max:9999999999999999999999999999.99|required',
          'integer|digits:1|max:11',
          'restaurant_true'=>'required',
          'store_id'=>'required|exists:stores,id',
          'tag_id'=>'required|exists:store_categories,id',
          'gifts.*.name' => 'required|string|max:50',
          'gifts.*.image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'sizes.*.name_en' => 'required|string|max:50',
          'sizes.*.name_ar' => 'required|string|max:50',
          'sizes.*.price' => 'numeric|max:9999999999999999999999999999.99',
          'ingredients.*.name_en' => 'required|string|max:50',
          'ingredients.*.name_ar' => 'required|string|max:50',
          'ingredients.*.image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'ingredients.*.price' => 'numeric|max:9999999999999999999999999999.99',
          'ingredients.*.add_remove' => 'required|in:0,1',

          'services.*.name_en' => 'required|string|max:50',
          'services.*.name_ar' => 'required|string|max:50',
          'services.*.price' => 'numeric|max:9999999999999999999999999999.99',



          'preferences.*.name_en' => 'required|string|max:50',
          'preferences.*.name_ar' => 'required|string|max:50',
          'preferences.*.price' => 'numeric|max:9999999999999999999999999999.99',
         


          'options.*.name_en' => 'required|string|max:50',
          'options.*.name_ar' => 'required|string|max:50',
          'options.*.price' => 'numeric|max:9999999999999999999999999999.99',
          'options.*.image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',


          'sides.*.name_en' => 'required|string|max:50',
          'sides.*.name_ar' => 'required|string|max:50',
          'sides.*.price' => 'numeric|max:9999999999999999999999999999.99',
          'sides.*.image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'drinks.*' => 'exists:drinks,id',
          'addons.*' => 'exists:addons,id',
        ];
    }
}
