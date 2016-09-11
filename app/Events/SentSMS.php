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
    protected $http;

    /**
     * Create a new event instance.
     *
     * @param $callback
     * @param $http
     */
    public function __construct($callback, Client $http)
    {
        $this->callback = $callback;
        $this->http = $http;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     */
    public function handle()
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
