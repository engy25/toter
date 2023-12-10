<?php
 namespace App\Repositories\Cart;
use App\Models\Item;
use Illuminate\Support\Collection;
interface CartRepositories{
  public function get():Collection;
  public function add(Item $item,$quantity=1);

  public function delete(Item $item);

  public function update(Item $item, $quantity);

  public function clear();

  public function total():float;
}

?>
