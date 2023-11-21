<?php

namespace App\Http\Requests\Api\Auth\User;

use Illuminate\Foundation\Http\FormRequest;

class SocialRequest extends FormRequest
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
          'provider' => 'required|in:facebook,google,apple',
          'provider_id' => 'required|string|between:2,255',
          'type' => 'required|in:ios,android',
          'device_token' => 'required',
        ];
    }
}
