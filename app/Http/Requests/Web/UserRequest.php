<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:25',
            'phone'=>'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone',
            'country_code'=>'required|exists:countries,country_code',
            'password' => ['required', Rules\Password::defaults()],
            'image' => 'image',
           
        ];
    }
}
