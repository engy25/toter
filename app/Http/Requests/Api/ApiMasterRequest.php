<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;
class ApiMasterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    protected function failedValidation(Validator $validator)
    {
      $errors = $validator->messages();

      // Extract the field names from the error messages
      $fieldNames = array_keys($errors->messages());


      // Assuming there is only one field failing validation
      $fieldName = reset($fieldNames);

        throw new HttpResponseException(response()->json([

            'result'=>'failed',
            'message'=>$fieldNames,
            'errors' => $validator->messages(),
            'status' => 422,
            'data' => null,

        ], 422));
    }
}
