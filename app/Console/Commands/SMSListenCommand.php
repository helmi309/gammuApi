<?php

namespace App\Console\Commands;

use App\Jobs\SendSMS;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SMSListenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listens on Redis for SMS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Redis::subscribe(env('REDIS_CHANNEL'), function ($message) {
            $message = json_decode($message, 1);
            dispatch(new SendSMS($message['to'], $message['message'], $message['callback'], new Client()));
        });
    }
}
