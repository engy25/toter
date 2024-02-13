<?php

namespace App\Http\Controllers\dashboard\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\UserStore;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\{User, Country, Store};
use Spatie\Permission\Models\Role;
use App\Http\Requests\dash\Restaurant\{StoreRestaurantUsersRequest,UpdateRestaurantUsersRequest};

class RestaurantUsersController extends Controller
{
  /**
   * the Restaurant user :the users that make dashboard in restaurant to assign the delivery to the order and receive the orders
   */
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function index()
  {
    return view("content.restaurantUser.index");
  }

  /**paginate the users */
  public function paginationUser(Request $request)
  {

    $users = User::role("Restaurant", "web")->latest()->paginate(2);

    return view("content.restaurantUser.pagination_index", compact("users"))->render();

  }


  public function searchUser(Request $request)
  {

    $searchString = '%' . $request->search_string . '%';

    $users = User::role("Restaurant", "web")->where(function ($query) use ($searchString) {

      $query->where("fname", 'like', $searchString)
        ->orWhere('email', 'like', $searchString)
        ->orWhere('phone', 'like', $searchString);
    })->latest()->paginate(2);

    if ($users->count() > 0) {
      // Return the search results as HTML
      return view("content.restaurantUser.pagination_index", compact("users"))->render();
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
    $stores = Store::all();

    return view("content.restaurantUser.create", compact("countries", "stores"));
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(StoreRestaurantUsersRequest $request)
  {
    \DB::beginTransaction();

    try {

      $role = Role::findByName('Restaurant', 'web');

      $user = new User;
      $user->fname = $request->fname;
      $user->phone = $request->phone;
      $user->country_code = $request->country;
      $user->email = $request->email;
      $user->password = $request->password;
      $user->is_active = 1;
      $user->role_id = $role->id;
      $user->store_id =$request->store_id;

      $user->save();

      $user->assignRole($role);




      \DB::commit();

      return redirect()->route('restaurantusers.index')->with('success', 'User created successfully.');


    } catch (\Exception $e) {
      // Rollback the transaction in case of an exception
      \DB::rollBack();

      // Log the error
      \Log::error($e->getMessage());

      // Return an error response or handle the exception as needed
      return redirect()->route('restaurantusers.index')->with('error', 'Error creating user.');
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
  public function edit(User $restaurantuser)
  {
    $countries = Country::all();
    $stores = Store::all();
    return view("content.restaurantUser.update", compact("restaurantuser", "countries","stores"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $restaurantuser
   */
  public function update(UpdateRestaurantUsersRequest $request, User $restaurantuser)
  {


    $restaurantuser->update([
      'fname' => $request->fname,
      'lname' => $request->lname,
      'email' => $request->email,
      'country_code' => $request->country,
      'phone' => $request->phone,

    ]);
    if ($request->password != null) {

      $restaurantuser->update(['password' => $request->password]);
    }



    // Redirect back or to a specific route after the update
    return redirect()->route('restaurantusers.index', $restaurantuser->id)->with('success', 'Delivery updated successfully');
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy($restaurantuser)
  {

    try {
      $user = User::findOrFail($restaurantuser);
      $user->delete();

      return response()->json(['status' => true, 'msg' => "User Deleted From Store Successfully Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }
}
