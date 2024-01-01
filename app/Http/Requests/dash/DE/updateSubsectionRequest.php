<?php

namespace App\Http\Requests\dash\DE;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class updateSubsectionRequest extends FormRequest
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
      $subsectionTranslationId = $this->route('subsection');


      return [
        'name_en' => [
          'required',
          'string',
          'max:255',
          Rule::unique('subsection_translations', 'name')->ignore($subsectionTranslationId->id, 'sub_section_id'),
        ],
        'name_ar' => [
          'required',
          'string',
          'max:255',
          Rule::unique('subsection_translations', 'name')->ignore($subsectionTranslationId->id, 'sub_section_id'),
        ],
        'description_en' => 'nullable|string|max:500',
        'description_ar' => 'nullable|string|max:500',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        'section_id' => 'required|exists:sections,id',
       
      ];
    }
}
