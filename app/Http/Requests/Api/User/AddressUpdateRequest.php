<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
          'title' => 'nullable|in:المنزل ,عمل,امي,غير',
          'building' => 'nullable|min:3,max:200',
          'street' => 'nullable|min:3,max:200',
          'apartment' => 'nullable|min:3,max:200',
          'phone' => 'nullable|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone',
          'country_code' => 'nullable|exists:countries,country_code',
          'default' => 'nullable|in:1,0',
          'lat' => 'nullable|numeric',
          'lng' => 'nullable|numeric',
          'instructions' => 'nullable|min:3,max:200',
        ];
    }
}
