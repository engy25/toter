<?php

namespace App\Http\Controllers\dashboard\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\{Store, User, OrderCallcenter, Address, item};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;

class OrderController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   */

  public function searchItem(Request $request, $order)
  {
    $searchString = '%' . $request->search_string . '%';

    $the_order = OrderCallcenter::whereId($order)->firstOrFail();

    $store = Store::with([
      "items",
      "items.drinks",
      'items.sides',
      'items.gifts',
      'items.Removeingredients',
      'items.Removeingredients',
      'items.services',
      'items.options',
      'items.preferences'
    ])
      ->whereId($the_order->store_id)
      ->where(function ($query) use ($searchString) {
        $query->whereHas('items.translations', function ($subQuery) use ($searchString) {
          $subQuery->where('name', 'like', $searchString)
            ->orWhere("description", 'like', $searchString);
        })->orWhereHas("items", function ($subQuery) use ($searchString) {
          $subQuery->where("price", 'like', $searchString);
        });
      })->firstOrFail();

    if ($store->count() > 0) {
      return view("content.orderCallcenter.partials.search-results", compact("store", "searchString"))->render();
    } else {
      return response()->json(["status" => 'nothing_found']);
    }
  }





  public function createStores(User $user)
  {
    $stores = Store::whereHas("translations")->whereHas("items")->get();

    return view("content.traditionalUser.createStore", compact("stores", "user"));
  }



  public function storeStores(Request $request, User $user)
  {
    \DB::beginTransaction();

    try {
      $address = Address::where("user_id", $user->id)->firstOrFail();

      $validated = $request->validate([
        "store" => "required|exists:stores,id"
      ]);

      $store = Store::firstOrFail();


      $orderCallCenter = new OrderCallcenter([
        'store_id' => $validated["store"],
        'user_id' => $user->id,
        'address_id' => $address->id,

      ]);

      $orderCallCenter->save();

      \DB::commit();

      return redirect()->route('orders.create', ['id' => $orderCallCenter->id])->with('success', 'Pleaze Complete The Stage');
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
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */

  public function create(OrderCallcenter $id)
  {
    $searchString="";

    $store = Store::with([
      "items",
      "items.drinks",
      'items.sides',
      'items.gifts',
      'items.Removeingredients',
      'items.Removeingredients',
      'items.services',
      'items.options',
      'items.preferences'

    ])->where("id", $id->store_id)->firstOrFail();

    return view("content.orderCallcenter.create", compact("id","store","searchString"));

  }
  public function store(Request $request, OrderCallcenter $id)
  {
    dd($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function show(Order $order)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function edit(Order $order)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Order $order)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function destroy(Order $order)
  {
    //
  }
}
