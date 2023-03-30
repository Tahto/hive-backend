<?php

namespace App\Events;

use App\Models\Modules\Wit\Planning\CapacityCharge;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WitCapcacityCharge
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $capacityCharge;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CapacityCharge $capacityCharge)
    {
        $this->capacityCharge = $capacityCharge;
    }

    /**
     * Comment
     *
     * @return \App\Models\Comment  $comment
     */
    public function capacityCharge(): capacityCharge
    {
        return $this->capacityCharge;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
