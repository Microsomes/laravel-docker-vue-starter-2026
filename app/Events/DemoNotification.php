<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemoNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;

    public string $timestamp;

    public function __construct()
    {
        $this->message = 'Hello from Laravel Reverb! '.now()->toTimeString();
        $this->timestamp = now()->toIso8601String();
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('demo'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'notification.sent';
    }
}
