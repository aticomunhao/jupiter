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

       $schedule->job(new ImportarAssociadosJob)
            ->everyFiveMinutes()
            ->withoutOverlapping()
           ->before(function () {
                Log::info('⏳ [Scheduler] Iniciando ImportarAssociadosJob...');
            })
            ->onSuccess(function () { // Similar ao after(), mas mais explícito
                Log::info('✅ [Scheduler] ImportarAssociadosJob finalizado com SUCESSO.');
            })
            ->onFailure(function () {
                Log::error('❌ [Scheduler] ImportarAssociadosJob FALHOU.');
            });
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
