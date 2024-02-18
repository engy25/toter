<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Notification, User};
use Carbon\Carbon;
use App\Http\Resources\Api\User\ShowNotificationResource;
use App\Helpers\Helpers;

class NotificationController extends Controller
{
  //

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function getNotifications()
  {

    $notifications = Notification::where('user_id', auth("api")->user()->id)->latest()->get();

    return $this->helper->
      responseJson(
        'success',
        trans('api.auth_data_retreive_success'),
        200,
        [
          'notifications' =>
            ShowNotificationResource::collection($notifications)
        ]
      );



  }

  public function show($id)
  {
    $notification = auth('api')->user()->notifications()->find($id);

    if (!$notification) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        404,
        null
      );
    }
    if (is_null($notification->read_at)) {

      $notification->update(["is_read" => "1", "read_at" => Carbon::now()]);
    }


    return $this->helper->
      responseJson(
        'success',
        trans('api.auth_data_retreive_success'),
        200,
        [
          'notifications' =>
            new ShowNotificationResource($notification)
        ]
      );


  }


  public function destroy($id)
  {
    $notification = auth('api')->user()->notifications()->find($id);

    if (!$notification) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        404,
        null
      );
    }
    $notification->delete();


    $theNotification= auth('api')->user()->notifications()->latest()->get();

    return $this->helper->
      responseJson(
        'success',
        trans('api.notif_deleted_successfully'),
        200,
        [
          'notifications' =>
            ShowNotificationResource::collection($theNotification)
        ]
      );


  }


  public function countNotifications()
  {
    $count_read = Notification::where('user_id', auth('api')->id())->where('is_read', 1)->count();

    $count_not_read = Notification::where('user_id', auth('api')->id())->where('is_read', 0)->count();


    return $this->helper->
    responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      [
        'is_read' => $count_read, 'not_read' => $count_not_read,
      ]
    );




   

  }

  /**
   * it is related to the notification channel
   */
  public function pushSubscribe(Request $request)
  {

    // $data = json_decode($request->getContent(), true);
    Notification::create([
      "data" => $request->getContent(),

      "notifiable_type" => "App\Models\User",
      "notifiable_id" => 165,
      "user_id" => 165,

    ]);

  }

}
