<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class EditPasswordRequest extends ApiMasterRequest
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
    public function rules()
    {
        return [
            'old_password' => ['required','min:6',function ($attribute, $value, $fail) {
                if (! \Hash::check($value, auth("api")->user()->password)) {
                    $fail(trans('api.auth_old_password_not_correct'));
                }
            }],
            'password' =>'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm_password'=>'required|same:password',
        ];
    }

    public function messages()
    {
     
        return[
            'password.regex' =>trans('api.password-regex'),
            
        
        ];
    }
}
