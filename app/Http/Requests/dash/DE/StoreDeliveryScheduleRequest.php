<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreDeliveryScheduleRequest extends FormRequest
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
      $deliveryId = $this->input('delivery_id');
      return [
        'day_id' => [
            'required',
            Rule::unique('delivery_schedules')->where(function ($query) use ($deliveryId) {
                return $query->where('delivery_id', $deliveryId);
            }),
        ],
        'fromTime' => 'required',
        'toTime' => 'required',
    ];
    }
}
