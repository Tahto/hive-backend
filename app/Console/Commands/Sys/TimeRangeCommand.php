<?php

namespace App\Console\Commands\Sys;

use Illuminate\Console\Command;
use App\Models\Sys\TimeRange;

class TimeRangeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time:range';


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

        $now = date("H:i");
        $delay = date("H:i", strtotime($now . ' -30 minutes'));

        $lines = TimeRange::get([
            'id',
            'time',
            'hour',
            'minute',
            'active',
            'passed',
        ]);

        foreach ($lines as $key => $value) {

            $value['time'] = date("H:i", strtotime($value['time']));
            $value['passed'] = $value['time'] <= $delay;
            $value['active'] = $value['time'] > $delay && $value['time'] < $now;

            try {
                $temp = TimeRange::find($value['id']);

                $temp->passed =  $value['passed'];
                $temp->active =  $value['active'];
                $temp->save();
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
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
