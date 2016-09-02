<?php

namespace App\Console\Commands;

use App\Key;
use Illuminate\Console\Command;

class RevokeKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:revoke {key : Auth key to revoke.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke authentication key.';

    protected $key;

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
        $this->key = $this->argument('key');
        $this->line('Revoking auth key');
        if (!$this->key) {
            $this->error('You need to provide a key');
            die();
        }
        $key = Key::where('key', $this->key)->first();
        if (!$key) {
            $this->error('You need to provide an authentic key');
            die();
        }
        Key::destroy($key->id);
        $this->info('Successfully revoked key ' . $this->key);
    }
}
