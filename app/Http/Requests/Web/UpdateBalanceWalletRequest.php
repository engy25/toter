<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBalanceWalletRequest extends FormRequest
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
            "add_balance"=>"required|min:1,max:100000|numeric",
            //"take_balance"=>"nullable|min:1,max:100000|numeric",
        ];
    }
}
