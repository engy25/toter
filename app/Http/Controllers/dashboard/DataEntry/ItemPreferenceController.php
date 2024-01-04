<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Preference,Item,PreferenceTranslation};
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\PreferenceStoreRequest;
class ItemPreferenceController extends Controller
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
    public function store(PreferenceStoreRequest $request)
    {
      $item = Item::whereId($request->item_id)->first();
      $preference = new Preference;

      $preference->price = $request->price;
      $preference->item_id = $request->item_id;
      $preference->store_id = $request->store_id;

      // Save the $preference to get the ID
      $preference->save();

      // Create translations with the Service ID
      PreferenceTranslation::create(['name' => $request->name_en, 'preference_id' => $preference->id, 'locale' => 'en']);
      PreferenceTranslation::create(['name' => $request->name_ar, 'preference_id' => $preference->id, 'locale' => 'ar']);

      if ($preference) {
        return response()->json([
          'status' => true,
          'message' => 'Preference Added Successfully',
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Failed to add Preference',
        ], 500); // Internal Server Error status code
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function show(Preference $preference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function edit(Preference $preference)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preference $preference)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function destroy($itempreference)
    {
      try {
        $preference = Preference::where("id", $itempreference)->first();
        $preference->translations()->delete();
        $preference->delete();
        return response()->json(['status' => true, 'msg' => "Preference Deleted Successfully"]);
      } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
      }

    }
}
