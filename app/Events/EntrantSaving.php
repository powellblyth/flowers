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
    public Entrant $entrant;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Entrant $entrant)
    {
        $this->entrant = $entrant;
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
