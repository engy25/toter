<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Coupon, Store};
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\dash\DE\StoreCouponRequest;

class CouponController extends Controller
{


  public function searchCoupon(Request $request)
  {
    $searchString = '%' . $request->search_string . '%';

    $coupons = Coupon::whereHas('store.translations', function ($query) use ($searchString) {
      $query->where('name', 'like', $searchString)
        ->orWhere('description', 'like', $searchString);
    })
      ->orWhere('code', 'like', $searchString)
      ->orWhere('discount_percentage', 'like', $searchString)
      ->orWhere('expire_date', 'like', $searchString)
      ->with([
        'store' => function ($query) {
          $query->select('id');
        }
      ])
      ->latest()
      ->paginate(PAGINATION_COUNT);

    if ($coupons->count() > 0) {
      // Return the search results as HTML
      return view("content.coupon.pagination_index", compact("coupons"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $locale = LaravelLocalization::getCurrentLocale();
    $coupons = Coupon::
      with([
        'store' => function ($query) {
          $query->select('id');
        }
      ])

      ->latest()->paginate(PAGINATION_COUNT);



    return view("content.coupon.index", compact("coupons"));
  }
  public function paginationCoupon(Request $request)
  {

    $coupons = Coupon::
      with([
        'store' => function ($query) {
          $query->select('id');
        }
      ])

      ->latest()->paginate(PAGINATION_COUNT);

    return view("content.coupon.pagination_index", compact("coupons"))->render();

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

   */
  public function store(StoreCouponRequest $request)
  {
    $coupon = Coupon::create([
      "store_id" => $request->store_id,
      'code' => $request->code,
      'expire_date' => $request->expire_date,
      'discount_percentage' => $request->discount_percentage,
      'max_user_used_code' => $request->max_user_used_code,

      'is_active' => 1

    ]);

    if ($coupon) {
      return response()->json([
        "status" => true,
        "message" => "Coupon Added Successfully"
      ]);
    } else {
      return response()->json([
        "status" => false,
        "message" => "Failed to add Coupon"
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Coupon  $coupon

   */
  public function show(Coupon $coupon)
  {
    return view("content.coupon.show", compact("coupon"));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Coupon  $coupon
   * @return \Illuminate\Http\Response
   */
  public function edit(Coupon $coupon)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Coupon  $coupon
   */
  public function update(Request $request, Coupon $coupon)
  {

    $couponId = $coupon->id;
    $rules = [

      'up_code' => 'required',
      'string|unique:coupons,code,' . $couponId,
      'upexpire_date' => 'required|date|after:now',
      'updiscount_percentage' => 'numeric|required|integer|max:100',
      'up_store_id' => 'required|exists:stores,id',
      'upmax_user_used_code' => 'numeric|integer|required|digits_between:1,11|max:99999999999',

    ];
    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    if ($coupon->users->count() > 0) {

      return response()->json(['status' => false, 'msg' => "This Coupon Is Used You Canoot Update It ."], 500);
    }

    $coupon->store_id = $request->up_store_id;
    $coupon->expire_date = $request->upexpire_date;
    $coupon->discount_percentage = $request->updiscount_percentage;
    $coupon->code = $request->up_code;
    $coupon->max_user_used_code = $request->upmax_user_used_code;
    $coupon->is_active = $request->is_active;

    $coupon->save();


    return response()->json([
      "status" => true,
      "message" => "Coupon updated successfully"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Coupon  $coupon
   * @return \Illuminate\Http\Response
   */
  public function destroy(Coupon $coupon)
  {
    if ($coupon->users->count() > 0) {

      return response()->json(['status' => false, 'msg' => "This Coupon Is Used You Canoot Delete It ."], 422);
    }

    $coupon->delete();

    return response()->json(['status' => true, 'msg' => "Offer Deleted Successfully"]);
  }
  /**
   * Dispplay the stores that have coupon
   */
  public function storeIndex()
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $stores = Store::with([
      "translations" => function ($query) use ($locale) {
        $query->select("store_id", "name")->where("locale", $locale);
      }
    ])->select('id')->get();
    return response()->json($stores);

  }

}
