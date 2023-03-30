<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Sys\Users;
use App\Console\Commands\Sys\SectorsN1;
use App\Console\Commands\Sys\SectorsN2;
use App\Console\Commands\Sys\Managers;
use App\Console\Commands\Sys\SectorsN1Manager;


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

        $hora = '07:18';
    
        $schedule->command('users:update')->dailyAt(date("H:i",strtotime($hora." + 1 minutes")));
        $schedule->command('sectorsn1:update')->dailyAt(date("H:i",strtotime($hora." + 5 minutes")));
        $schedule->command('sectorsn2:update')->dailyAt(date("H:i",strtotime($hora." + 5 minutes")));
        $schedule->command('managers:update')->dailyAt(date("H:i",strtotime($hora." + 5 minutes")));
        $schedule->command('sectorsn1manager:update')->dailyAt(date("H:i",strtotime($hora." + 5 minutes")));
        $schedule->command('sectorsn2manager:update')->dailyAt(date("H:i",strtotime($hora." + 5 minutes")));
        $schedule->command('sectorsn2manager:update')->dailyAt(date("H:i",strtotime($hora." + 5 minutes")));
        $schedule->command('gip:daily')->dailyAt(date("H:i",strtotime($hora." + 1 minutes")));

        $schedule->command('calendar')->daily();
        // $schedule->command('time:range')->everyMinute();
        $schedule->command('time:range')->everyTenMinutes();
        $schedule->command('boletimhh:filters')->everyThreeHours();

        
        // // reinicia a fila a cada 5 minutos para manter a fila sempre ativa
        // $schedule->command('queue:restart')
        //     ->everyFiveMinutes();

        // // 
        // $schedule->command('queue:work --daemon')
        //     ->everyMinute()
        //     ->withoutOverlapping();
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
