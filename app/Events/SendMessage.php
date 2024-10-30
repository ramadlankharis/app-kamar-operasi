<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userName;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($userName, $message)
    {
        $this->userName = $userName;
        $this->message = $message;
    }

       /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn() : Channel
    {

        return new Channel('chat-channel');
    }

    public function broadcastWith()
    {
        return [
            'userName' => $this->userName,
            'message' => $this->message,
        ];
    }
}
