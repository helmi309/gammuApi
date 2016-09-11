<?php

/*
 * This file is part of Gammu Web API
 *
 * (c) Kristian Drucker <kristian@rolmi.sk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Events;

use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;

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
     */
    public function handle()
    {
        if ($this->callback && env('CALLBACK_URL')) {
            $http->post(env('CALLBACK_URL'), [
                'json' => [
                    'callback' => $this->callback,
                ],
            ]);
        }
    }
}
