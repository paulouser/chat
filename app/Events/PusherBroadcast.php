<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $user;
    public string $room;

    public function __construct(string $message, string $user, string $room)
    {
        $this->message = $message;
        $this->user = $user;
        $this->room = $room;
    }

    public function broadcastOn(): array
    {
        return ['public'];
    }

    public function broadcastAs(): string
    {
        return 'chat'.$this->room;
    }
}
