<?php

namespace App\Http\Requests\dash\CallCenter;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderButlerRequest extends FormRequest
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
      $rules=[
        'district_id' => 'required|exists:districts,id',
        'city_id' => "required|exists:cities,id",
        'building' => 'required|string|between:3,200',
        'street' => 'required|string|between:3,200',
        'apartment' => 'required|string|between:3,200',
        'instructions' => 'nullable|string|between:3,200',
        'tocity_id'=> "required|exists:cities,id",
        'todistrict_id'=> 'required|exists:districts,id',
        'tobuilding'=> 'required|string|between:3,200',
        'tostreet' => 'required|string|between:3,200',
        'toapartment'=>'required|string|between:3,200',
        'toinstructions'=>'nullable|string|between:3,200',
        'orderType' => 'required|exists:butlers,id',
        'expected_cost'=>'nullable|numeric|digits_between:1,30|regex:/^\d{1,28}(\.\d{1,2})?$/',
        'expected_delivery'=>'required|numeric|digits_between:1,30|regex:/^\d{1,28}(\.\d{1,2})?$/',


      ];
      if($this->orderType==2){
        $rules['items'] = 'required|array';
        $rules['item.*.item'] = 'required|string|min:3|max:1000';
        $rules['items.*image'] = 'mimes:jpeg,jpg,png,gif|nullable|max:1000';


      }else {
        $rules["order"] = "required|string|min:4|max:65535";

      }
      return $rules;
    }
  }
