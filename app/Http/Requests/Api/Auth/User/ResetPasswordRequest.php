<?php

namespace App\Http\Requests\Api\Auth\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends ApiMasterRequest
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
            'phone'=>'required|exists:users,phone',
            'country_code'=>'required|exists:countries,country_code',
            'otp'=>'required|exists:users,otp',
            'password' =>'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/|min:6',
            'confirm_password'=>'required|same:password',
        ];
    }

    public function messages()
    {
     
        return[
            'password.regex' =>trans('api.password-regex'),
            'phone.regex'=>trans('api.phone.regex'),
        
        ];
    }
}
