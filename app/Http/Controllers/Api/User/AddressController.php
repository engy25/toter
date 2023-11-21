<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddressUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\AddressStoreRequest;
use App\Models\Address;
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\Address\AddressResource;
use Illuminate\Support\Facades\DB;
class AddressController extends Controller
{

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();

  }

  function checkAddresses($default, $address_id = null)
  {

    if ($default == 1) {
      Address::where(['user_id' => auth('api')->user()->id, 'default' => 1])
        ->when($address_id, function ($query) use ($address_id) {
          $query->where('id', '!=', $address_id);
        })->update(['default' => 0]);
    }

    return true;
  }


  public function show($address_id)
  {
      $address=Address::where(["user_id"=>auth('api')->user()->id,"id"=>$address_id])->first();

      if(!$address){
          return $this->helper->responseJson('failed',trans('api.address_not_found'),422,null);

      }
      return $this->helper->responseJson('success',trans('api.auth_data_retreive_success'),200,["Addresses"=>new AddressResource($address)]);



  }
  public function store(AddressStoreRequest $request)
  {
    $user_id = auth('api')->user()->id;

    $address_data = $request->validated();

    $address_data['user_id'] = $user_id;


    $default_address = Address::where(['user_id' => $user_id, 'default' => 1])->first();
    /**check theat the fist address its default==1 */
    if (!$default_address) {
      $address_data['default'] = 1;
      // dd($address_data);

    }

    //$address_data['default']=$request->default;
    $this->checkAddresses($request->default);
    Address::create($address_data);


    $address = Address::where('user_id', auth('api')->user()->id)->orderByDesc('default')->cursor();
    return $this->helper->responseJson('success', trans('api.data_saved_success'), 200, ["Addresses" => AddressResource::collection($address)]);

  }



  public function getAddresses()
  {

    $addresses = Address::where('user_id', auth('api')->id())->orderByDesc('default')->cursor();
    //dd($addresses);

    return $this->helper->responseJson('success', trans('api.auth_data_retreive_success'), 200, ["Addresses" => AddressResource::collection($addresses)]);



  }

  public function update(AddressUpdateRequest $request,$id)
  {
      $address=Address::where(["id"=>$id,"user_id"=>auth('api')->user()->id])->first();
      DB::beginTransaction();

      try{
          $this->checkAddresses($request->default,$address->id);
          $address->update($request->validated());
          Db::commit();

          $address=Address::where(['user_id'=>auth('api')->user()->id])->orderByDesc('default')->cursor();
          return $this->helper->responseJson('success',trans('api.data_saved_success'),200,["Addresses"=>AddressResource::collection($address)]);


      }catch(\Exception $e)
      {
          DB::rollBack();
          return $this->helper->responseJson('failed',trans('api.auth_failed'),422,null);
      }


  }


  public function destroy($id)
  {
    $address = Address::where([
      'id' => $id,
      'user_id' => auth('api')->id(),
    ])->first();

    if (!$address) {

      return $this->helper->responseJson('failed', trans('api.address_not_found'), 422, null);
    }

    $address->delete();

    $addresses = Address::where(['user_id' => auth('api')->id()])->orderByDesc('default')->cursor();

    return $this->helper->responseJson('success', trans('api.address_delete_success'), 200, ["Addresses" => AddressResource::collection($addresses)]);


  }
}
