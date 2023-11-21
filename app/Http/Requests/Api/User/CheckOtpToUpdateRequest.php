<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class CheckOtpToUpdateRequest extends FormRequest
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
        $phoneRegex = '/^[1]{1}[0-9]{9}$/';
        return [
            'phone'=>'required|regex:/^[^0]\d{8,19}$/|numeric|unique:users,phone'.$this->users,
            'country_code'=>'required|exists:countries,country_code',
            'otp'=> 'required|regex:/[0-9]{4}/',
        ];
    }

    public function messages()
    {
     
        return[
            
            'phone.regex'=>trans('api.phone.regex'),
        
        ];
    }
}

