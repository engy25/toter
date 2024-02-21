<?php

namespace App\Http\Controllers\dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Notification};
use App\Notifications\General\{GeneralNotification, FCMNotification};
use Illuminate\Notifications\DatabaseNotification;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Carbon\Carbon;

class NotificationController extends Controller
{

  public function index()
  {
    $userId = auth()->user()->id;
    $notifications = Notification::where("user_id", $userId)->latest()->get();
    foreach($notifications as $notification)
    {
      if($notification->is_read==0)
      {
        $notification->update(["is_read"=>1,"read_at"=>Carbon::now()]);
      }
    }
    return view("content.notifications.index",compact("notifications"));


  }



  public function show($id)
  {
    if (!request()->ajax()) {
      $userId = auth()->user()->id;
      $notification = DatabaseNotification::whereHasMorph('notifiable', [User::class], function ($q) use ($userId) {
        $q->where('notifiable_id', $userId);
      })->findOrFail($id);
      if (!$notification->read_at) {
        $notification->update(['read_at' => now(), "is_read" => 1]);
      }
      return response()->json($notification);
    }
  }

  public function fetch()
  {
    $adminUserId = auth()->user()->id;
    $locale = LaravelLocalization::getCurrentLocale();

    $notifications = Notification::where('user_id', $adminUserId)->where("is_read", 0)->get();

    $formattedNotifications = [];
    foreach ($notifications as $notification) {
      $formattedNotifications[] = [
        'id' => $notification->id,
        'title' => $notification->getTranslation('title', $locale),
        'data' => $notification->getTranslation('data', $locale),
        'notifiable_type' => $notification->notifiable_type,
        'notifiable_id' => $notification->notifiable_id,
      ];

    }

    // Mark notifications as read (optional)
    Notification::where('user_id', $adminUserId)->update(['is_read' => true]);




    return response()->json(['notifications' => $formattedNotifications]);
  }


}
