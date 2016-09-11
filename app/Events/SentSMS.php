<?php

namespace App\Events;

use GuzzleHttp\Client;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SentSMS
{
    use SerializesModels;

    protected $callback;

    /**
     * Create a new event instance.
     *
     * @param $callback
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @param Client $http
     */
    public function handle(Client $http)
    {
        if($this->callback && env('CALLBACK_URL')) {
            $http->post(env('CALLBACK_URL'), [
                'json' => [
                    'callback' => $this->callback
                ]
            ]);
        }
    }
}
