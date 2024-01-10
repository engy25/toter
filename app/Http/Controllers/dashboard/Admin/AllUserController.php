<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User,Country};
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role, Permission};

class AllUserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {

    $userRole = Role::where("name", "User")->first();
    $roles = Role::all();
    $statuses = [
      [
        "id" => 1,
        "name" => "Active",
      ],
      [
        "id" => 2,
        "name" => "Inactive",
      ]
    ];


    $users = User::whereDoesntHave("roles", function ($query) use ($userRole) {
      $query->where("name", $userRole);

    })->latest()->paginate(PAGINATION_COUNT);
    return view("content.Alluser.index", compact("users", "roles", "statuses"));
  }

  /**paginate the users */
  public function paginationUser(Request $request)
  {
    $userRole = Role::where("name", "User")->first();

    $users = User::whereDoesntHave("roles", function ($query) use ($userRole) {
      $query->where("name", $userRole);

    })->latest()->paginate(PAGINATION_COUNT);

    return view("content.Alluser.pagination_index", compact("users"))->render();

  }


  /**
   * search for user
   */
  public function searchUser(Request $request)
  {
      $searchString = '%' . $request->search_string . '%';
      $role = $request->role;
      $status = $request->status;

      $users = User::when($request->search_string, function ($q) use ($searchString) {
          $q->where("fname", 'like', $searchString)
              ->orWhere('email', 'like', $searchString)
              ->orWhere('phone', 'like', $searchString);
      })->when($request->role, function ($q) use ($role) {
          $q->where("role_id", $role);
      })->when($request->status, function ($q) use ($status) {
          $q->where("is_active", $status);
      })->latest()->paginate(PAGINATION_COUNT);

      if ($users->count() > 0) {
          return view("content.Alluser.pagination_index", compact("users"))->render();
      } else {
          return response()->json([
              "status" => 'nothing_found',
          ]);
      }
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
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   */
  public function edit(User $alluser)
  {
    $countries = Country::all();
    return view("content.Alluser.update", compact("alluser","countries"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   */
  public function update(Request $request, User $alluser)
  {



    $alluser->update([
      'fname' => $request->fname,
      'lname' => $request->lname,
      'email' => $request->email,
      'country_code' => $request->country,
      'phone' => $request->phone,

    ]);
    if ($request->password != null) {

      $alluser->update(['password' => $request->password]);
    }


    // Handle image upload
    if ($request->hasFile('upimage')) {
      $alluser->update(['image' => $request->upimage]);

    }

    // Redirect back or to a specific route after the update
    return redirect()->route('allusers.index')->with('successUpdate', 'User updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    //
  }
}
