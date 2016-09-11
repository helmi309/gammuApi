<?php

/*
 * This file is part of Gammu Web API
 *
 * (c) Kristian Drucker <kristian@rolmi.sk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;

class SendSMS implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $message;
    protected $callback;
    protected $http;

    /**
     * Create a new job instance.
     *
     * @param to
     * @param $message
     * @param $callback
     *
     */
    public function __construct($to, $message, $callback)
    {
        $this->to = $to;
        $this->message = $message;
        $this->callback = $callback;
        $this->http = new Client();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $command = 'gammu sendsms TEXT '.$this->to.' -text "'.$this->message.'"';
        exec($command);
        if($this->callback && env('CALLBACK_URL')) {
            $this->http->post(env('CALLBACK_URL'), [
                'json' => [
                    'callback' => $this->callback
                ]
            ]);
        }
    }
}
