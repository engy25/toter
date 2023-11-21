<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends ApiMasterRequest
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
            'fname'=>'nullable|string|between:3,40',
            'lname'=>'nullable|string|between:3,40',
            'nickname'=>'nullable|string|between:3,40',
            'dob' => 'nullable|date|date_format:Y-m-d',
            'email_address'=>'nullable|email|max:40',
            'image'=>'mimes:jpeg,jpg,png,gif|nullable|max:10000',
        ];
    }
}
