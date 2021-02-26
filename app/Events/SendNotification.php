<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendNotification implements  ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $actionId;
    public $actionData;
    public function __construct($actionId,$actionData)
    {
        //
        $this->actionId=$actionId;
        $this->actionData=$actionData;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('send-notification');
    }

    public function broadcastAs()
    {
        return 'SendNotification';
    }

    public function broadcastWith()

    {
        return [
            'actionId'=>$this->actionId,
            'actionData'=>$this->actionData
        ];
//        return ['title'=>'Notification message will go here'];
    }
}
