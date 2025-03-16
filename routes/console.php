<?php

use App\Console\Commands\MigrateAndSeedCommand;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

app()->make(MigrateAndSeedCommand::class);
