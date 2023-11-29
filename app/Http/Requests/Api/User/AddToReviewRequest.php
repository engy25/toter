<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddToReviewRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        'type'=>'required|in:store,offer,item',
        'reviewable_id'=>'required|numeric',
        'rating' => 'required|numeric|between:1,5',
        'comment' => 'nullable|string|max:255',

    ];
    }
}
