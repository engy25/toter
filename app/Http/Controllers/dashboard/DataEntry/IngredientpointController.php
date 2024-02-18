<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Ingredient, Item, IngredientTranslation};
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Http\Requests\dash\DE\IngredientpointStoreRequest;
use Illuminate\Validation\Rule;

class IngredientpointController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }
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
  public function store(IngredientpointStoreRequest $request)
  {

    $item = Item::whereId($request->item_id)->first();
    $ingredient = new Ingredient;
    $ingredient->add = $request->add;
    $ingredient->price = 0;
    $ingredient->item_id = $request->item_id;
    $ingredient->store_id = $request->store_id;


    // // Handle image upload
    if ($request->hasFile('image')) {

      $image = $request->file('image');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/ingredients/');
      $ingredient->image = $imagePath;
    }

    // Save the ingredient to get the ID
    $ingredient->save();

    // Create translations with the Ingredient ID
    IngredientTranslation::create(['name' => $request->name_en, 'ingredient_id' => $ingredient->id, 'locale' => 'en']);
    IngredientTranslation::create(['name' => $request->name_ar, 'ingredient_id' => $ingredient->id, 'locale' => 'ar']);

    if ($ingredient) {
      return response()->json([
        'status' => true,
        'message' => 'Ingredient Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add Ingredient',
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Ingredient  $ingredient
   * @return \Illuminate\Http\Response
   */
  public function show(Ingredient $ingredient)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Ingredient  $ingredient
   * @return \Illuminate\Http\Response
   */
  public function edit(Ingredient $ingredient)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Ingredient  $ingredient
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Ingredient $ingredient)
  {

    $rules = [
      "up_add" => "required_in:1,0",
      'upimage' => 'max:10000',
      'upprice' => 'numeric|max:9999999999999999999999999999.99|required',
      'upnameen' => [
        'required',
        'string',
        'max:30',
        'min:3',
        Rule::unique('ingredient_translations', 'name')->ignore($ingredient->id, 'ingredient_id')->where(function ($query) use ($request, $ingredient) {
          // Check if the English name is different
          return $request->upnameen !== $ingredient->nameTranslation('en');
        }),
      ],
      'upnamear' => [
        'required',
        'string',
        'max:30',
        'min:3',
        Rule::unique('ingredient_translations', 'name')->ignore($ingredient->id, 'ingredient_id')->where(function ($query) use ($request, $ingredient) {
          // Check if the Arabic name is different
          return $request->upnamear !== $ingredient->nameTranslation('ar');
        }),
      ],
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $ingredient->update([
      "item_id" => 1,
      "store_id" => 1,
      "price" => $request->upprice,
      'add' => $request->up_add,
      'image' => $request->upimage, // assuming 'image' is a valid column in your table
    ]);

    IngredientTranslation::where(['ingredient_id' => $ingredient->id, "locale" => "en"])->update(['name' => $request->upnameen]);
    IngredientTranslation::where(['ingredient_id' => $ingredient->id, "locale" => "ar"])->update(['name' => $request->upnamear]);

    return response()->json([
      "status" => true,
      "message" => "Ingredient updated successfully"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Ingredient  $ingredient
   * @return \Illuminate\Http\Response
   */
  public function destroy(Ingredient $ingredientpoint)
  {
    try {

      $ingredientpoint->translations()->delete();
      $ingredientpoint->delete();
      return response()->json(['status' => true, 'msg' => "Ingredient Deleted Successfully"]);
    } catch (\Exception $e) {
      if ($e->getMessage() === "Cannot delete Ingredient, It is related to other tables") {
        return response()->json(['status' => false, 'msg' => $e->getMessage()], 403);
      }
      return response()->json(['status' => false, 'msg' => "An error occurred while deleting the Ingredient."], 500);
    }
  }
}
