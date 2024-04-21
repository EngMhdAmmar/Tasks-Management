<?php

namespace App\Console;

use App\Jobs\DailyTask;
use App\Jobs\MonthlyTask;
use App\Jobs\SendReminders;
use App\Jobs\WeeklyTask;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new DailyTask)->daily();
        $schedule->job(new WeeklyTask)->weekly();
        $schedule->job(new MonthlyTask)->monthly();
        $schedule->job(new SendReminders)->daily();
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
