<?php

namespace App\Events;

use App\Entrant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EntrantSaving
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $entrant;

    /**
     * Create a new event instance.
     * @param  Entrant  $entrant
     *
     * @return void
     */
    public function __construct(Entrant $entrant)
    {
        $this->entrant = $entrant;
        //
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
