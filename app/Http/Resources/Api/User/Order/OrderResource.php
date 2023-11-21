<?php

namespace App\Http\Resources\Api\User\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\User\Order\AttachmentResource;
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       
        return[
            "id"=>$this->id,
            "text"=>$this->text,
            "from_lat"=>$this->from_lat,
            "from_lng"=>$this->from_lng,
            "to_lat"=>$this->to_lat,
            "to_lng"=>$this->to_lng,



        ];
    }
}
