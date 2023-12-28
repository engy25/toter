<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;

class SideStoreRequest extends FormRequest
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
          "name_en" => 'required|string|max:30|min:3|unique:ingredient_translations,name',
          "name_ar" => 'required|string|max:30|min:3|unique:ingredient_translations,name',
          'sideImage'=>'required|max:10000',
          'price'=>'numeric|max:9999999999999999999999999999.99|required',


        ];
    }
}
