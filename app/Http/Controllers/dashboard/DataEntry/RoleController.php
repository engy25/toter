<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Http\Requests\dash\DE\StoreRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

  public function paginationRole()
  {
    $roles = Role::where("name","!=","Admin")->latest()->paginate(PAGINATION_COUNT);

    return view("content.role.pagination_index", compact("roles"))->render();
  }

  public function searchRole(Request $request)
  {
    $searchString = '%' . $request->search_string . '%';

    $roles = Role::where("name","!=","Admin")->Where('name', 'like', $searchString)
      ->orWhere('guard_name', 'like', $searchString)
      ->orWhere('created_at', 'like', $searchString)
      ->orderBy('created_at', 'desc') // Assuming you want to order by the 'created_at' column
      ->paginate(PAGINATION_COUNT);

    if ($roles->count() > 0) {
      // Return the search results as HTML
      return view("content.role.pagination_index", compact("roles"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }

  public function index()
  {

    $roles =Role::where("name","!=","Admin")->latest()->paginate(PAGINATION_COUNT);

    return view("content.role.index", compact("roles"));
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request

   */
  public function store(StoreRoleRequest $request)
  {
    $role = Role::create([
      'guard_name' => $request->guard,
      'name' => $request->name,

    ]);

    if ($role) {
      return response()->json([
        "status" => true,
        "message" => "Role Added Successfully"
      ]);
    } else {
      return response()->json([
        "status" => false,
        "message" => "Failed to add Role"
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Role  $role
   */
  public function update(Request $request, Role $role)
  {

    $roleId = $role->id;
    $rules = [
      "guard" => "required",
      "name" => 'required|string|max:30|min:3|unique:roles,guard_name,' . $roleId,
    ];
    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    if ($role->permissions->count() > 0 || $role->users->count() > 0) {

      return response()->json(['status' => false, 'msg' => "This Role Is Used You Canoot Update It ."], 500);
    }

    $role->guard_name = $request->guard;
    $role->name = $request->name;

    $role->save();

    return response()->json([
      "status" => true,
      "message" => "Role updated successfully"
    ]);
  }




  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function destroy(Role $role)
  {
    if ($role->users->count() > 0 || $role->permissions->count() > 0) {

      return response()->json(['status' => false, 'msg' => "This Role Is Used You Canoot Delete It ."], 422);
    }

    $role->delete();

    return response()->json(['status' => true, 'msg' => "Role Deleted Successfully"]);
  }









}
