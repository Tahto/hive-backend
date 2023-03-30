<?php

namespace App\Console\Commands\Sys;

use Illuminate\Console\Command;
use App\Models\Sys\User;
use App\Models\SourceGipConsQuadroUnificado;
use Illuminate\Support\Facades\Hash;
use App\Models\Sys\Calendar;

class CalendarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $job['name'] = get_class($this);
        $job['event_id'] = 0; // 0 para rotinas 
        $job['status'] = 1;
        $job['running'] = 1;

        $jobControl = job_control($job);

        $first = date("Y-01-01");
        $last   = date('Y-12-31', strtotime('+2 year'));
        $dates = [];
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $weekday = date('w', $current) + 1;

            $date = [
                'year' => date('Y', $current),
                'month' => date('m', $current),
                'day' => date('d', $current),
                'date' => date('Y-m-d', $current),
                'weekday' =>  $weekday,
                'business_day' =>  !in_array($weekday, [1, 7]),
                'active' =>  date('Y-m-d', $current)  == date('Y-m-d'),
                'passed' =>  date('Y-m-d', $current)  < date('Y-m-d'),
            ];

            if (!Calendar::where('date', date('Y-m-d', $current))->count()) {
                try {
                    Calendar::create($date);
                } catch (\Throwable $th) {

                    $jobControl['status'] = 0;
                    $jobControl['running'] = 0;

                    job_control($job, $jobControl->id);
                    return Command::FAILURE;
                }
            }
            $dates[] = $date;
            $current = strtotime('+1 day', $current);
        }

        job_control($job, $jobControl->id);
        return Command::SUCCESS;
    }

    public function failed()
    {
        $job['name'] = get_class($this);
        $job['event_id'] = 0;
        $job['status'] = 0;
        $job['running'] = 0;

        job_control($job);
        return Command::FAILURE;
    }
}
