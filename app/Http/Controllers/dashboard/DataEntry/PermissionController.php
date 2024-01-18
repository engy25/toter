<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Permission,Role};
use App\Http\Requests\dash\DE\StorePermissionRequest;

class PermissionController extends Controller
{
  public function paginationPermission()
  {
    $permissions = Permission::latest()->paginate(PAGINATION_COUNT);

    return view("content.permission.pagination_index", compact("permissions"))->render();
  }

  public function searchPermission(Request $request)
  {
    $searchString = '%' . $request->search_string . '%';

    $permissions = Permission::whereHas('roles', function ($query) use ($searchString) {
      $query->where('name', 'like', $searchString);
    })
      ->orWhere('name', 'like', $searchString)
      ->orWhere('guard_name', 'like', $searchString)
      ->orWhere('created_at', 'like', $searchString)
      ->orderBy('created_at', 'desc') // Assuming you want to order by the 'created_at' column
      ->paginate(PAGINATION_COUNT);

    if ($permissions->count() > 0) {
      // Return the search results as HTML
      return view("content.permission.pagination_index", compact("permissions"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }

  public function index()
  {

    $permissions = Permission::latest()->paginate(PAGINATION_COUNT);

    return view("content.permission.index", compact("permissions"));
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request

   */
  public function store(StorePermissionRequest $request)
  {
    $permisssion = Permission::create([
      'guard_name' => $request->guard,
      'name' => $request->name,

    ]);
    $role_admin=Role::findByName("Admin");
    $role_admin->givePermissionTo($permisssion);

    if ($permisssion) {
      return response()->json([
        "status" => true,
        "message" => "Permission Added Successfully"
      ]);
    } else {
      return response()->json([
        "status" => false,
        "message" => "Failed to add Coupon"
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Permission  $permission
   */
  public function update(Request $request, Permission $permission)
  {

    $permissionId = $permission->id;
    $rules = [
      "guard" => "required",
      "name" => 'required|string|max:30|min:3|unique:permissions,guard_name,' . $permissionId,
    ];
    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    if ($permission->roles->count() > 0 || $permission->users->count() > 0) {

      return response()->json(['status' => false, 'msg' => "This Permission Is Used You Canoot Update It ."], 500);
    }

    $permission->guard_name = $request->guard;
    $permission->name = $request->name;

    $permission->save();

    return response()->json([
      "status" => true,
      "message" => "Permission updated successfully"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Permission  $permission
   * @return \Illuminate\Http\Response
   */
  public function destroy(Permission $permission)
  {
    if ($permission->users->count() > 0 || $permission->roles->count() > 0) {

      return response()->json(['status' => false, 'msg' => "This Permission Is Used You Canoot Delete It ."], 422);
    }

    $permission->delete();

    return response()->json(['status' => true, 'msg' => "Permission Deleted Successfully"]);
  }


}
