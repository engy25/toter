<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{StoreCategory,StoreCategoryTranslation};
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\tagStoreRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(tagStoreRequest $request)
    {
      $tag = new StoreCategory;

      $tag->store_id = $request->store_id;

      // Save the tag to get the ID
      $tag->save();

      // Create translations with the Ingredient ID
      StoreCategoryTranslation::create(['name' => $request->name_en, 'description' => $request->description_en,'store_category_id' => $tag->id, 'locale' => 'en']);
      StoreCategoryTranslation::create(['name' => $request->name_ar, 'description' => $request->description_en, 'store_category_id' => $tag->id, 'locale' => 'ar']);

      if ($tag) {
        return response()->json([
          'status' => true,
          'message' => 'Tag Added Successfully',
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Failed to add Tag',
        ], 500); // Internal Server Error status code
      }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Http\Response
     */
    public function show(StoreCategory $storeCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreCategory $storeCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreCategory $tag)
    {
      $rules = [

        'up_name_en' => [
          'required',
          'string',
          'max:30',
          'min:3',
          Rule::unique('store_category_translations', 'name')->ignore($tag->id, 'store_category_id')->where(function ($query) use ($request, $tag) {
            // Check if the English name is different
            return $request->up_name_en !== $tag->nameTranslation('en');
          }),
        ],
        'up_name_ar' => [
          'required',
          'string',
          'max:30',
          'min:3',
          Rule::unique('store_category_translations', 'name')->ignore($tag->id, 'store_category_id')->where(function ($query) use ($request, $tag) {
            // Check if the Arabic name is different
            return $request->up_name_ar !== $tag->nameTranslation('ar');
          }),
        ],
        'description_en' => 'nullable|string|max:500',
        'description_ar' => 'nullable|string|max:500',
      ];


      $validator = \Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }
      StoreCategoryTranslation::where(['store_category_id' => $tag->id, "locale" => "en"])->update(['name' => $request->up_name_en,'description' => $request->up_description_en]);
      StoreCategoryTranslation::where(['store_category_id' => $tag->id, "locale" => "ar"])->update(['name' => $request->up_name_ar,'description' => $request->up_description_ar]);

      return response()->json([
        "status" => true,
        "message" => "Tag updated successfully"
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Http\Response
     */

     public function destroy($tag)
     {
       try {
         $tag = StoreCategory::findOrFail($tag);
         $tag->delete();

         return response()->json(['status' => true, 'msg' => "Tag Deleted Successfully"]);
       } catch (\Exception $e) {
         return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
       }
     }
}
