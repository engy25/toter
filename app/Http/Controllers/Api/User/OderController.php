<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order,User,OrderButler};
use App\Http\Requests\Api\User\AddOrderRequest;

class OderController extends Controller
{
  public function store(AddOrderRequest $request)
  {
    $order=Order::whereId(74)->first();

    $user=new User();

    dd($user->assignDriverToOrderButler($order)->id);

  }




}
