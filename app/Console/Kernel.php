<?php

namespace App\Console;

use App\Console\Commands\CleanDuplicateKey;
use App\Console\Commands\RemakePermission;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RemakePermission::class,
        CleanDuplicateKey::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('autosendmail:afterexpire')->dailyAt('07:00');
        $schedule->command('backup:run')->daily()->at('02:00');
        $schedule->command('backup:clean')->daily()->at('05:00');
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
