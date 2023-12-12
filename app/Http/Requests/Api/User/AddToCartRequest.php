<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AddToCartRequest extends ApiMasterRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */

  //  const INGREDIENT_RULE = ["required", "exists:ingredients,id"];

  // const ADDON_RULE = 'required|numeric|exists:addons,id';
  // const SERVICE_RULE = 'required|numeric|exists:services,id';
  // const PREFERENCE_RULE = 'required|numeric|exists:preferences,id';
  // const DAY_RULE = 'required|numeric|exists:days,id';
  // const DRINK_RULE = 'required|numeric|exists:drinks,id';
  // const SIDE_RULE = 'required|numeric|exists:sides,id';

  public function rules()
  {
    $data = [
      "item_id" => 'required|numeric|exists:items,id',
      "size_id" => 'nullable|numeric|exists:sizes,id',
      "qty" => 'required|numeric|min:1',
      "preference_id" => 'nullable|numeric|exists:preferences,id',
      "option_id" => 'nullable|numeric|exists:options,id',
      "gift_id" => 'nullable|numeric|exists:item_gifts,id',

      "add_ingredients" => $this->input('ingredients') !== null ? 'required|exists:ingredients,id' : 'nullable',
      "remove_ingredients" => $this->input('ingredients') !== null ? 'required|exists:ingredients,id' : 'nullable',
      "addons" => $this->input('addons') !== null ? 'required|exists:addons,id' : 'nullable',
      "services" => $this->input('services') !== null ?  'required|exists:services,id' : 'nullable',

      //  "preferences" => $this->input("preferences") !== null ? 'required|exists:preferences,id': 'nullable',
      "days" => $this->input("days") !== null ?  'required|exists:days,id' : 'nullable',
      "drinks" => $this->input("drinks") !== null ? 'required|exists:drinks,id' : 'nullable',
      "sides" => $this->input("sides") !== null ? 'required|exists:sides,id': 'nullable',
      "notes" => "nullable|min:3|max:250",
    ];



    return $data;
  }







}
