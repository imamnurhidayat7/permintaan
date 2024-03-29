<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        Commands\updateKurs::class,
        Commands\tutupRequest::class,
        \App\Console\Commands\ClearQueue::class,
        \App\Console\Commands\ShowPendingQueue::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tutup-request')->daily();
        $schedule->command('update-kurs')->dailyAt('08:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
