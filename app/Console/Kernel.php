<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ImportarAssociadosJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
        protected function schedule(Schedule $schedule): void

    {

        $schedule->job(new ImportarAssociadosJob)->dailyAt('13:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
