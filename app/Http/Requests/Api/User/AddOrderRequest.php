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
          'items' => 'required|array',
          'items.*.item_id' => 'required|exists:items,id',
          'items.*.size_id' => 'nullable|exists:sizes,id',
          'items.*.drinks' => 'nullable|array',
          'items.*.addingredients' => 'nullable|array',

          'items.*.removeingredients' => 'nullable|array',
          'items.*.options' => 'nullable|array',
          'items.*.sides' =>'nullable|array',
          'items.*.services' => 'nullable|array',
          'items.*.notes' => 'nullable|min:3|max:500',
          'items.*.qty' => 'required|numeric|min:1',
          "district_id"=>'required|exists:districts,id',
          'payment_type' => 'required|in:cash,visa',
          'transaction_id' => 'required_if:payment_type,visa',
          'coupon_id' => 'nullable|exists:coupons,id',
          'address_id' => 'required|exists:addresses,id',

        ];
    }
}
