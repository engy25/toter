<?php
namespace App\Repositories\Cart;

use App\Models\{Item, Cart};

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;



class CartModelRepositories implements CartRepositories
{
  public function get(): Collection
  {

  }
  public function add(Item $item, $quantity = 1)
  {
    return Cart::create([
      "user_id" => auth('api')->user()->id,
      "item_id" => $item->id,
      "quantity" => $quantity,

    ]);

  }

  public function delete(Item $item)
  {
    Cart::where(["item_id" => $item->id, "user_id" => auth('api')->user()->id])
      ->delete();
  }

  public function update(Item $item, $quantity)
  {
    Cart::where(["item_id" => $item->id, "user_id" => auth('api')->user()->id,"status_id"=>null])
      ->update(["quantity" => $quantity]);

  }
/**
 * Delete All Items In cart
 */
  public function clear()
  {
    Cart::where(["user_id" => auth('api')->user()->id,"status_id"=>null])
      ->delete();
  }

  public function total():float
  {

  }


  /**in web */
  public function getCookieId()
  {
    $cookieId=Cookie::get("cart_id");
    if($cookieId)
    {
      $cookieId=Str::uuid();
      Cookie::queue("cart_id",$cookieId,Carbon::now()->addDays(30));
    }
    return $cookieId;
  }
}

?>
