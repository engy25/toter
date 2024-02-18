<?php

namespace App\Http\Controllers\dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Notification};
use App\Notifications\General\{GeneralNotification, FCMNotification};
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{

  public function index()
  {

    if (! request()->ajax()) {
        $userId = auth()->user()->id;
        $notifications = DatabaseNotification::whereHasMorph('notifiable',[User::class],function($q) use($userId){
            $q->where('notifiable_id',$userId);
        })->latest()->paginate(PAGINATION_COUNT);

        return response()->json($notifications);

    }


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



}
