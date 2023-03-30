<?php

namespace App\Jobs\Modules\Wit\Planning;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Modules\Wit\Planning\CapacityCharge;
use App\Models\Modules\Wit\Planning\CapacityResult;
use App\Models\Modules\Wit\Planning\CapacityIndicator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CapacityChargeResultDimJob implements ShouldQueue
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
        
        
        $indicators = CapacityIndicator::where('type','0')->get(['id', 'title'])->toArray();

        //Abre o arquivo para manipulação
        $lines = json_decode(Storage::get($capacityCharge['file_dir_json']), true);

        // Deleta os arquivos do período 
        CapacityResult::where('ref', $capacityCharge['ref'])->delete();

        $value= [];

        foreach ($lines as $key => $value) {

            $temp['sector_id'] = $value['sector_id'];
            $temp['ref'] = $value['ref'];
            $temp['date'] = $value['date'];
            $temp['manager_n5_id'] = $value['cd_mat_diretor'];
            $temp['manager_n4_id'] = $value['cd_mat_gerente_relac'];
            $temp['manager_n3_id'] = $value['cd_mat_gerente_local'];
            
            $value[] = $temp;
            foreach ($indicators as $key => $ind) {

                if(array_key_exists($ind['title'], $value)){

                    $temp['value'] = $value[$ind['title']];
                    $temp['indicator_id'] = $ind['id'];
        
                    $temp['type'] = 0; // zero para dimencionado 

                    if (!empty($temp['value'])) {
                        try {
                            CapacityResult::create($temp);
                        } catch (\Throwable $th) {
                            Log::error($th);
                        }
                    }
                }
                
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
