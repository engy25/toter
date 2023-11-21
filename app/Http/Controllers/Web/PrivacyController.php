<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Privacy,
    PrivacyTranslation
};
use App\Http\Requests\Web\AboutUpdateRequest;
class PrivacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $privacies = Privacy::all();
        return view("privacies.index", compact("privacies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('privacies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutUpdateRequest $request)
    {
        $privacy = Privacy::create([]);
        PrivacyTranslation::create([
            "privacy_id" => $privacy->id,
            "name" => $request->name_en,
            "description" => $request->description_en,
            "locale" => "en"
        ]);
        PrivacyTranslation::create([
            "privacy_id" => $privacy->id,
            "name" => $request->name_ar,
            "description" => $request->description_ar,
            "locale" => "ar"
        ]);
        return redirect()->route('privacies.index')->with('success', 'About has been Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Privacy $privacy)
    {
        return view("privacies.edit", compact("privacy"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutUpdateRequest $request, Privacy $privacy)
    {
        $privacy->save();

        $privacy_en = $privacy->translate("en");
        $privacy_en->name = $request->name_en;
        $privacy_en->description = $request->description_en;
        $privacy_en->save();

        $privacy_ar = $privacy->translate("ar");
        $privacy_ar->name = $request->name_ar;
        $privacy_ar->description = $request->description_ar;
        $privacy_ar->save();
        return redirect()->route('privacies.index')->with('success', 'Privacy has been Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Privacy $privacy)
    {
        $privacy->delete();
        return response()->json(['status'=>true,'msg'=>"Privacy Deleted Successfully","id"=>$privacy->id]);
        
    }
}