<?php

namespace App\Jobs\Modules\Wit\Planning;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Modules\Wit\Planning\CapacityCharge;
use App\Http\Controllers\Modules\Wit\Planning\CapacityChargeController;
use App\Models\Modules\Wit\Planning\CapacityIndicator;
use Illuminate\Support\Facades\Storage;
use App\Models\Sys\GipSectorN1;
use App\Models\Modules\Wit\Planning\CapacityManagerSector;

class CapacityChargeManagerSectorJob implements ShouldQueue
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

        $managerSector =  array_values($managers->unique(function ($item) {
            return $item['manager_n3_id'] . $item['manager_n4_id'] . $item['manager_n5_id'] . $item['sector_id'];
        })->toArray());

        $managerSector = array_map(function ($item) {
            $sector =   GipSectorN1::get(['id', 'name', 'uf'])->find($item['sector_id']);
            $temp['sector_id'] = $item['sector_id'];
            $temp['name'] = $sector ? $sector['name'] : '';
            $temp['uf'] = $sector ? $sector['uf'] : '';

            $temp['manager_n3_id'] = $item['manager_n3_id'];
            $temp['manager_n4_id'] = $item['manager_n4_id'];
            $temp['manager_n5_id'] = $item['manager_n5_id'];
            $temp['ref'] = $item['ref'];
            return $temp;
        },  $managerSector);


        CapacityManagerSector::where('ref', $capacityCharge['ref'])->delete();
        foreach ($managerSector as $key => $value) {
            if ($value['name']) {
                CapacityManagerSector::create($value);
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
