<?php

namespace App\Console\Commands;

use App\Key;
use Illuminate\Console\Command;

class CreateKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a authentication key.';

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
        $this->line('Genetating key');
        $key = $this->generateKey(32);
        $keys = Key::where('key', $key)->first();
        if ($keys) {
            $key = $this->generateKey(32);
        }
        Key::create(['key' => $key]);
        $this->info('Successfully genetated key! Please keep it safe.');
        $this->line($key);
    }

    private function generateKey($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
