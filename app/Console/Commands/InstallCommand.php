<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time installation for Gammu api.';

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
        $this->line('Initializing installation');
        exec('cp ' . base_path('.env.example') . ' ' . base_path('.env'));
        $this->line('Creating database');
        exec('touch ' . database_path('database.sqlite'));
        exec('php ' . base_path('artisan') . ' migrate');
        $this->info('Migrated database');
    }
}
