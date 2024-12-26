<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealTimeDisplay implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $status;
    public $idDisplay;
    public $updated_at;
    public $roomIsActive;

    /**
     * Create a new event instance.
     */
    public function __construct($status, $id, $updated_at, $roomIsActive)
    {
        $this->status = $status;
        $this->idDisplay = $id;
        $this->updated_at = $updated_at;
        $this->roomIsActive = $roomIsActive;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn() : Channel
    {

        return new Channel('display-channel-'. $this->idDisplay);
    }

    public function broadcastWith()
    {
        return [
            'status' => $this->status,
            'idDisplay' => $this->idDisplay,
            'updatedAt' => $this->updated_at,
            'roomIsActive' => $this->roomIsActive
        ];
    }

}
