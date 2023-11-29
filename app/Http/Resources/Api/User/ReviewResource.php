<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          "user_id"=>$this->user->id,
          "user_name"=>$this->user->fname,
          "user_image"=>$this->user->image,
          'reviewable_id' =>$this->reviewable_id,
          "rating"=>(double)$this->rating,
          "comment"=>$this->comment,
          'created_at'=>$this->created_at->toFormattedDateString(),

        ];
    }
}
