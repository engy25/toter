<?php

namespace App\Http\Resources\Api\Delivery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\StatusTranslation;
class SimpleOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status_confirm = StatusTranslation::where("name", "confirm")->first();

        $time_of_receiving_order = $this->status_id == $status_confirm->id ? $this->delivery_date_time->diffForhumans() : null;

        return [
            "id" => $this->id,
            "user_image" => $this->user->image,
            'user_name' => $this->user->fullname,
            "text"=>$this->text,
            //  'status'=>$this->status->name,
            'order_number' => $this->order_number,
            'total' => $this->total,
            'created_at' => $this->created_at->toDateString(),
            /**the time from  */
            'the_time_the_delivery_confirm_order' => $time_of_receiving_order,


        ];
    }
}