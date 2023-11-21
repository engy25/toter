<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    About,
    AboutTranslation
};
use App\Http\Requests\Web\AboutUpdateRequest;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::all();
        return view("abouts.index", compact("abouts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('abouts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutUpdateRequest $request)
    {
        $about = About::create([]);
        AboutTranslation::create([
            "about_id" => $about->id,
            "name" => $request->name_en,
            "description" => $request->description_en,
            "locale" => "en"
        ]);
        AboutTranslation::create([
            "about_id" => $about->id,
            "name" => $request->name_ar,
            "description" => $request->description_ar,
            "locale" => "ar"
        ]);
        return redirect()->route('abouts.index')->with('success', 'About has been Created successfully');
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
    public function edit(About $about)
    {
        return view('abouts.edit', compact("about"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(AboutUpdateRequest $request, About $about)
    {
        $about->save();

        $about_en = $about->translate("en");
        $about_en->name = $request->name_en;
        $about_en->description = $request->description_en;
        $about_en->save();

        $about_ar = $about->translate("ar");
        $about_ar->name = $request->name_ar;
        $about_ar->description = $request->description_ar;
        $about_ar->save();
        return redirect()->route('abouts.index')->with('success', 'About has been Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        $about->delete();
        return response()->json(['status'=>true,'msg'=>"About Deleted Successfully","id"=>$about->id]);
        
    }
}