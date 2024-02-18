<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title'=>$this->title,
            'data'=> $this->data,
            'user_id'=> $this->user_id,
            'is_read'=> $this->is_read,
            'read_at'=> $this->read_at,
            'created_at'=> $this->created_at->diffForhumans(),
            'updated_at'=> $this->updated_at->diffForhumans()
        ];
    }
}
