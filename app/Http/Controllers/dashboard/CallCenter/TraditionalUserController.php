<?php

namespace App\Http\Controllers\Dashboard\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Spatie\Permission\Models\Role;
class TraditionalUserController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function index()
  {

    $users = User::role("User")->latest()->paginate(3);


    return view("content.user.index", compact("users"));
  }

  public function searchUser(Request $request, $roleName)
  {

    $searchString = '%' . $request->search_string . '%';

    $users = User::role($roleName)->where(function ($query) use ($searchString) {

      $query->where("fname", 'like', $searchString)
        ->orWhere('email', 'like', $searchString)
        ->orWhere('phone', 'like', $searchString);
    })->latest()->paginate(3);

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
