<?php

namespace App\Events;

use App\Models\Entrant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EntrantSaving
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public Entrant $entrant)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array|\Illuminate\Broadcasting\Channel
    {
        return new PrivateChannel('channel-name');
    }
}
