<?php

namespace App\Jobs\Modules\Wit\Planning;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Modules\Wit\Planning\CapacityCharge;
use Illuminate\Support\Facades\Storage;

use App\Models\Modules\Wit\Planning\CapacityManagerN5;
use App\Models\Sys\User;

class CapacityChargeManagerN5Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tries = 3;
    private $capacityCharge;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CapacityCharge $capacityCharge)
    {
        $this->capacityCharge = $capacityCharge;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $capacityCharge = $this->capacityCharge;
        $capacityCharge['file_dir_json'] = str_replace('.txt', '.json', $capacityCharge['file_dir']);

        $job['name'] = get_class($this);
        $job['event_id'] = $capacityCharge->id;
        $job['status'] = $capacityCharge->status;
        $job['running'] = 1;

        $jobControl = job_control($job);
        
        if ($capacityCharge->status != 1) {
            job_control($job, $jobControl->id);
            exit;
        }

        if(!Storage::exists($capacityCharge['file_dir_json'])){
            $job['status'] = 0;
            job_control($job, $jobControl->id);
            exit;
        }

        $lines = json_decode(Storage::get($capacityCharge['file_dir_json']), true);
        

        $managers = collect(array_map(function ($item) {
            $temp['manager_n3_id'] = $item['cd_mat_gerente_local'];
            $temp['manager_n4_id'] = $item['cd_mat_gerente_relac'];
            $temp['manager_n5_id'] = $item['cd_mat_diretor'];
            $temp['sector_id'] = $item['sector_id'];
            $temp['ref'] = $item['ref'];
            return $temp;
        }, $lines));

        $managerN5 =  array_values($managers->unique(function ($item) {
            return  $item['manager_n5_id'];
        })->toArray());

        $managerN5 = array_map(function ($item) {
            $user = User::get(['id', 'name'])->find($item['manager_n5_id']);
            $temp['name'] = !$user ? '' : $user['name'];
            $temp['manager_n5_id'] = !$user ? '' : $user['id'];
          
            $temp['ref'] = $item['ref'];
            return $temp;
        },  $managerN5);


        CapacityManagerN5::where('ref', $capacityCharge['ref'])->delete();
        foreach ($managerN5 as $key => $value) {
            if ($value['name']) {
                CapacityManagerN5::create($value);
            }
        };
        job_control($job, $jobControl->id);
    }

    public function failed()
    {
        $capacityCharge = $this->capacityCharge;
        $job['name'] = get_class($this);
        $job['event_id'] = $capacityCharge->id;
        $job['status'] = 0;
        $job['running'] = 0;

        job_control($job);
    }
}
