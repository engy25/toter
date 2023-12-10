<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ApiMasterRequest;
use App\Models\{Section, SubSection};
use Illuminate\Validation\Rule;
class RequestOfferType extends ApiMasterRequest
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
    // Offers in sections that are in the surrounded area
    // Sections with surrounded stores

    $lat=$this->header("lat");
    $lng=$this->header("lng");
    $surroundedSections = Section::SectionsWithSurroundedStores($lat, $lng);
    $subsection_have_offers = Subsection::whereIn("section_id", $surroundedSections->pluck('id')->toArray())->with('translations')->get();
    $discountCategories = $subsection_have_offers->pluck('id', 'name')->toArray();
    return [
      "subsection_name" => ["required",
      Rule::in(array_keys($discountCategories)),
      ]
    ];
  }
}
