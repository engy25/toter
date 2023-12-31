<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddOrderRequest extends ApiMasterRequest
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
            "district_id"=>$this->district_id,
            'payment_type' => 'required|in:cash,visa',
            'transaction_id' => 'required_if:payment_type,online',
            'coupon_id' => 'nullable|exists:coupons,id',
            'address_id' => 'required|exists:addresses,id',
            
        ];
    }
}
