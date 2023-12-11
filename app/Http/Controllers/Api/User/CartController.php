<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\AddToCartRequest;
use App\Models\Cart;

class CartController extends Controller
{
  //

  public function store(AddToCartRequest $request)
  {
    $ingredients = $request->all();

    // Do something with $ingredients, e.g., save to the database

    dd($ingredients);


  }
}
