<?php

namespace App\Console\Commands;

use App\Jobs\SendSMS;
use Illuminate\Console\Command;
use Predis\Client;
use Symfony\Component\Console\Output\OutputInterface;

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

    protected $redis;

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
        $this->connectRedis($this->output);
        $this->subscribe($this->redis);
    }

    public function connectRedis(OutputInterface $output)
    {
        if(!config('database.redis.default.host')) {
            $output->writeln('-----> Redis host not provided');
            die();
        }
        //dd('tcp://' . config('database.redis.default.host') . ':' . config('database.redis.default.port') . "?read_write_timeout=0");
        $this->redis = new Client('tcp://' . config('database.redis.default.host') . ':' . config('database.redis.default.port') . "?read_write_timeout=0");
    }

    public function subscribe(Client $redis)
    {
        $pubsub = $redis->pubSubLoop();
        $pubsub->subscribe(env('REDIS_CHANNEL'));
        foreach ($pubsub as $message) {
            switch ($message->kind) {
                case 'subscribe':
                    echo "-----> Subscribed to {$message->channel}", PHP_EOL;
                    break;
                case 'message':
                    $message = json_decode($message->payload, true);
                    dispatch(new SendSMS($message['to'], $message['message'], $message['callback'], new Client()));
                    break;
            }
        }
    }
}
