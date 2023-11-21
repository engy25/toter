<?php

namespace App\Http\Resources\Api\User\Order;

use App\Models\{
    StatusTranslation,
    Currency
};
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $status_confirm = StatusTranslation::where("name", "confirm")->first();

        $time_of_receiving_order = $this->status_id == $status_confirm->id ? $this->delivery_date_time->diffForhumans() : null;
        $default_currency = Currency::where("default", 1)->first();

        return [
            "id" => $this->id,
            "driver_image" => $this->delivery->image,
            'drivaer_name' => $this->delivery->fullname,
            //  'status'=>$this->status->name,
            'order_number' => $this->order_number,
            'total' => $this->total,
            'default_currency' => $default_currency,
            'created_at' => $this->created_at->toDateString(),
            /**the time from  */
            'the_time_the_delivery_confirm_order' => $time_of_receiving_order,
            'lat' => $this->to_lat,
            "lng" => $this->lng,

        ];
    }
}