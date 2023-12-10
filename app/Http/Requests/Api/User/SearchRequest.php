<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends ApiMasterRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize():bool
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
      'keyword' => 'nullable|string',
      //'category_id'=>'required|exists:categories,id',
      'min_price' => 'nullable|integer',
      //'max_price'=>'required_with:min_price|integer',
      'max_price' => 'nullable:min_price|integer',
      'rate' => 'nullable',
      'color_id' => 'nullable|array',
      'color_id.*' => 'integer',
      'type' => 'nullable|string'
    ];
  }
}
