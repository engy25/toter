<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Delivery;

class DeliveryUpdatedLocation implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $lat;
  public $lng;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($lng ,$lat)
  {
    //
    $this->lat = $lat;
    $this->lng = $lng;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    return new PrivateChannel('deliveries');
  }

  public function broadcastWith()
  {
    return [
      'lat' => $this->lat,
      'lng' => $this->lng,

    ];
  }
}
