<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendSMS implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
	
	protected $to;
	protected $message;
	
    /**
     * Create a new job instance.
     *
     * @param to
     * @param $message
     * @return void
     */
    public function __construct($to, $message)
    {
        $this->to = $to;
	    $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $command = 'gammu sendsms TEXT ' . $this->to . ' -text ' . $this->message;
	    exec($command);
    }
}
