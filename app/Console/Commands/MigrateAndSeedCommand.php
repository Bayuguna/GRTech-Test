<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateAndSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh-seed {--fresh : Drop all tables and migrate fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('fresh')) {
            $this->info('Running migrate:fresh...');
            Artisan::call('migrate:fresh', [], $this->getOutput());
        } else {
            $this->info('Running migrate...');
            Artisan::call('migrate', [], $this->getOutput());
        }

        $this->info('Running db:seed...');
        Artisan::call('db:seed', [], $this->getOutput());

        $this->info('Migration and seeding completed successfully!');
    }
}
