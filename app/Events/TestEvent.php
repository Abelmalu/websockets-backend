<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class TestEvent implements ShouldBroadcastNow
{

  
 
	public function broadcastOn()
	{
	   return [
      new Channel('test-channel')
    ];
	}
	public function broadcastWith(): array
   {
    return [
      'message' => 'Hello World'
    ];
  }
}