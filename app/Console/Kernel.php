<?php

namespace App\Console;

use App\Console\Commands\GenerateAppointment;
use App\Console\Commands\HelloCron;
use App\Jobs\EnviarCorreoJob;
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
        $schedule->command('inspire')->hourly();
        // $schedule->job(new EnviarCorreoJob())->everyMinute()->appendOutputTo(storage_path('logs/cron.log'));

        /* $schedule->command(HelloCron::class, ['--no-ansi'])
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/cron.log'));*/

        $schedule->command(GenerateAppointment::class, ['--no-ansi'])
            ->dailyAt('12:10')
            // ->everyMinute()
            ->appendOutputTo(storage_path('logs/generate-appointment.log'));
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
