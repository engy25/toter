<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{User,
    RoleTranslation,
    Country};
use Illuminate\Http\Request;
use App\Http\Requests\Web\{
    UpdateAdminRequest
};
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_role=RoleTranslation::Where("name","admin")->first();
        $admins=User::where("role_id",$admin_role->id)->orderByDesc("id")->paginate(PAGINATION_COUNT);
        return view("admins.index", compact(["admins"]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        return view("admins.show", compact(["admin"]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        $countries_code = Country::all();
        return view("admins.edit", compact(["admin","countries_code"]));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, User $admin)
    {
       
        $adminRole = RoleTranslation::where("name", "admin")->first();
        $country = Country::where("country_code", $request->country_code)->first();


        $updates = [
            'fullname' => $request->name,
            'image' => $request->image,
            'country_code' => $request->country_code,
            "phone" => $request->phone,
            'currency_id' => $country->currency_id,
            "email"=>$request->email
        ];
        $admin->update($updates);
        return redirect()->route('index.dashboard')->with('success', 'Admin has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        //
    }
}
