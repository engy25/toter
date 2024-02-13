<?php

namespace App\Http\Requests\Api\Delivery;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends ApiMasterRequest
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
            "lat"=>"required|numeric",
            "lng"=>"required|numeric",
            "type"=>"required|in:order,orderCallcenter,orderButler",
            "id"=>"required"
        ];
    }
}
