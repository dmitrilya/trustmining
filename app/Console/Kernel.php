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
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('ordering:update')->hourlyAt(15);
        $schedule->command('subscription:check')->daily();
        $schedule->command('coinprofit:update')->dailyAt('02:00');
        $schedule->command('art:update')->twiceDaily(0, 12);
        $schedule->command('trustfactors:update')->dailyAt('00:30');
        $schedule->command('auth:clear-resets')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
