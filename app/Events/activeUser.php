<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class activeUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public String $message;
    private User $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(String $message, User $user)
    {
        //
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //presence channel
        return new PresenceChannel('presence.chat.1');
    }
    public function broadcastAs()
    {
        return 'activeUser';
    }
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'user' => $this->user->only(['name', 'email'])
        ];
    }
}
