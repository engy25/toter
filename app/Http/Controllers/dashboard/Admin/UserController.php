<?php

namespace App\Http\Controllers\dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\dash\Admin\StoreUserRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Permission, Role};
use App\Models\{User, Country};
use App\Helpers\Helpers;

class UserController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }


  /**
   * Display a listing of the resource.
   *
   */
  public function indexUser($roleName)
  {

    $users = User::role($roleName)->latest()->paginate(PAGINATION_COUNT);


    return view("content.user.index", compact("users"));
  }
  /**
   * search for user
   */
  public function searchUser(Request $request, $roleName)
  {

    $searchString = '%' . $request->search_string . '%';

    $users = User::role($roleName)->where(function ($query) use ($searchString) {

      $query->where("fname", 'like', $searchString)
        ->orWhere('email', 'like', $searchString)
        ->orWhere('phone', 'like', $searchString);
    })->latest()->paginate(PAGINATION_COUNT);

    if ($users->count() > 0) {
      // Return the search results as HTML
      return view("content.user.pagination_index", compact("users"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }

  public function paginationUser(Request $request, $roleName)
  {

    $users = User::role($roleName)->latest()->paginate(PAGINATION_COUNT);
    return view("content.user.pagination_index", compact("users"))->render();

  }

  /**
   * Show the form for creating a new resource.
   *
   *
   */
  public function create()
  {
    $roles = Role::get();
    $countries = Country::all();

    return view("content.user.create", compact("roles", "countries"));
  }

  /**
   * Store a newly created resource in storage.
   *
   *
   */
  public function store(StoreUserRequest $request)
  {

      try {
          $role = Role::whereId($request->role)->first();


          if (!$role) {
              return redirect()->back()->with('error', 'Role not found.');
          }

          $user = new User;
          $user->fname = $request->fname;
          $user->lname = $request->lname;
          $user->country_code = $request->country;
          $user->email = $request->email;
          $user->phone = $request->phone;
          $user->country_code = $request->country;
          $user->password = $request->password;
          $user->is_active = 1;
          $user->role_id = $request->role;

          // Handle image upload
          if ($request->hasFile('image')) {
              $user->image = $request->image;
          }

          $user->save();

          // Switch guard context before calling assignRole
          if ($role->name == "Delivery") {

            $roleDelivery = Role::where('name', 'Delivery')->where('guard_name', 'api')->first();
            $user->assignRole($roleDelivery);
          }elseif($role->name =="User"){
            $roleUser = Role::where('name', 'User')->where('guard_name', 'api')->first();
            $user->assignRole($roleUser);
          }
           else {
              $user->assignRole($role->name);
          }
          $permissions = Permission::whereIn('id', $request->input('permissions', []))->get();
          $user->syncPermissions($permissions);

          \DB::commit();

          return redirect()->route('users.create')->with('success', 'User created successfully.');
      } catch (\Exception $e) {
          \DB::rollBack();
          return redirect()->back()->with('error', 'Failed to create user. ' . $e->getMessage());
      }
  }

  public function displayPermissions($roleId)
  {
    $role=Role::where("id",$roleId)->first();
    $permissions = $role->permissions()->get();

    return response()->json($permissions);

  }


}
