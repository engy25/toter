<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Currency;
class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $default_currency=Currency::where("default",1)->first();
        return [
            "id" => $this->id,
            "balance" => (double)$this->balance,
            "currency"=>$default_currency-> isocode
        ];
    }
}
