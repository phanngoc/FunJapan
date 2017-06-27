<?php

namespace App\Console;

use Carbon\Carbon;
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
        Commands\UpdateInviteCodeInOldUser::class,
        Commands\SendEmailNotifications::class,
        Commands\LogLastWeek::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('send:email-notifications')
                  ->daily();

        foreach (config('app.locales') as $locale) {
            $schedule->command('last_week:process ' . $locale)
                ->timezone(trans('datetime.time_zone', [], $locale))
                ->dailyAt('2:00');
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
