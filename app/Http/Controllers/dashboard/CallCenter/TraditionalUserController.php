<?php

namespace App\Http\Controllers\dashboard\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\{User, Country, Address};
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\Http\Requests\dash\CallCenter\StoreUserRequest;

class TraditionalUserController extends Controller
{
  /**
   * the traditional user :the user that doesnot have mobile that doesnot
   *  have account to login we make the account cause he make order by phone
   */
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function index()
  {

    return view("content.traditionalUser.index");
  }

  /**paginate the users */
  public function paginationUser(Request $request)
  {

    $users = User::role("User", "api")->where("is_traditional",1)->latest()->paginate(2);

    return view("content.traditionalUser.pagination_index", compact("users"))->render();

  }


  public function searchUser(Request $request)
  {

    $searchString = '%' . $request->search_string . '%';

    $users = User::role("User", "api")->where("is_traditional",1)->where(function ($query) use ($searchString) {

      $query->where("fname", 'like', $searchString)
        ->orWhere('email', 'like', $searchString)
        ->orWhere('phone', 'like', $searchString);
    })->latest()->paginate(2);

    if ($users->count() > 0) {
      // Return the search results as HTML
      return view("content.traditionalUser.pagination_index", compact("users"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $countries = Country::all();

    return view("content.traditionalUser.create", compact("countries"));
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(StoreUserRequest $request)
  {
    \DB::beginTransaction();

    try {


      $role = Role::findByName('User', 'api');

      $user = new User;
      $user->fname = $request->fname;

      $user->country_code = $request->country;

      $user->phone = $request->phone;
      $user->country_code = $request->country;
      $user->is_traditional = 1;

      $user->is_active = 1;
      $user->role_id = $role->id;


      $user->save();


      $user->assignRole($role);

      // Create a new address associated with the user
      $address = $user->addresses()->create([
        'building' => $request->building,
        'street' => $request->street,
        'apartment' => $request->apartment,
        'phone' => $user->phone,
        'country_code' => $user->country_code,
        'instructions' => $request->instructions,
        'default' => 1
      ]);


      \DB::commit();

      return redirect()->route('traditionalusers.index')->with('success', 'User created successfully.');
    } catch (\Exception $e) {
      // Rollback the transaction in case of an exception
      \DB::rollBack();

      // Log the error
      \Log::error($e->getMessage());

      // Return an error response or handle the exception as needed
      return redirect()->route('traditionalusers.index')->with('error', 'Error creating user and address.');
    }
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
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    //
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
