<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Scopes\ItemScope;

class ItemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $items = Item::withoutGlobalScope(new ItemScope)->
      with([
        'store' => function ($query) use ($locale) {
          $query->select('id');
        },
        'category' => function ($query) use ($locale) {
          $query->select('id');

        },
        'translations' => function ($query) use ($locale) {
          $query->select('item_id', 'name')->where('locale', $locale);

        },
      ])
      ->latest()->paginate(2);



    return view("content.item.indexItem", compact("items"));
  }


  public function paginationItem(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $items = Item::withoutGlobalScope(new ItemScope)->
      with([
        'store' => function ($query) use ($locale) {
          $query->select('id');
        },
        'category' => function ($query) use ($locale) {
          $query->select('id');

        },
        'translations' => function ($query) use ($locale) {
          $query->select('store_id', 'name')->where('locale', $locale);
        },
      ])->latest()->paginate(2);
    return view("content.item.paginationItem", compact("items"))->render();

  }




  public function searchItem(Request $request)
  {
      $locale = LaravelLocalization::getCurrentLocale();
      $searchString = '%' . $request->search_string . '%';

      $items = Item::where(function ($query) use ($searchString) {
          $query->whereHas('category.translations', function ($subQuery) use ($searchString) {
              $subQuery->where('name', 'like', $searchString);
          })->orWhereHas('translations', function ($subQuery) use ($searchString) {
              $subQuery->where('name', 'like', $searchString)
                  ->orWhere('description', 'like', $searchString);
          });
      })
      ->orWhere('price', 'like', $searchString)
      ->with([
          'section' => function ($query) {
              $query->select('id');
          },
          'translations' => function ($query) use ($locale) {
              $query->select('item_id', 'name')->where("locale", $locale);
          },
      ])
      ->latest()
      ->paginate(PAGINATION_COUNT);

      if ($items->count() > 0) {
          // Return the search results as HTML
          return view("content.item.paginationItem", compact("items"))->render();
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
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function show(Item $item)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function edit(Item $item)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Item $item)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function destroy(Item $item)
  {
    //
  }
}
