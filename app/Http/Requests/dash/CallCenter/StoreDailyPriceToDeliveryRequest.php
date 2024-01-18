<?php

namespace App\Http\Requests\dash\CallCenter;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyPriceToDeliveryRequest extends FormRequest
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
          'price'=>'numeric|max:9999999999999999999999.99|required',
        ];
    }
}
