<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\View;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    protected $notification;
    protected $locale;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notification, $locale)
    {
        $this->notification = $notification;
        $this->locale = $locale;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification.' . $this->locale->iso_code . '.' . $this->notification->user_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $html = View::make('layouts.includes._single_notification')
                ->with('notification', $this->notification)
                ->render();

        return [
            'html' => $html,
        ];
    }
}
