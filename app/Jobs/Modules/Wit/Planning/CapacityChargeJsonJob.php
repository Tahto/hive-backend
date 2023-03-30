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
use Illuminate\Support\Facades\Log;
use App\Traits\teste;

class CapacityChargeJsonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, teste;

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

        if (!Storage::exists($capacityCharge['file_dir'])) {
            $job['status'] = 0;
            job_control($job, $jobControl->id);
            exit;
        }

        try {

            //Abre o arquivo para manipulação 
            $contents = Storage::get($capacityCharge['file_dir']);

            //Quebra as linhas do .csv
            $contents = trim($contents, "\n");
            $lines = explode(PHP_EOL, $contents);

            // Pega o cabeçalho do arquivo na primeira linha
            $header = explode(';', $lines[0]);

            // remove a primeira linha
            array_shift($lines);

            $file = array_filter($lines);

            // Mapeia o array para recodificar as linhas
            $lines = array_map(function ($value) use ($header, $capacityCharge) {
                // // transforma o conteudo da linha em array
                $temp = explode(';', $value);

                // limpa o conteudo da linha temporrária
                $line = [];

                // corre os valores da linha para atribuir um valor do cabeçalho como key
                foreach ($temp as $key => $valueLine) {
                    if(!empty($header[$key])){
                    $line[$header[$key]] = utf8_encode($valueLine);
                    }
                };

                unset($temp);

                $line['sector_id'] = $line['cd_setor'];
                $line['ref'] = $capacityCharge['ref'];

                $line['date'] = implode("/", array_reverse(explode("/", $line['dt_data'])));
                $line['cd_mat_gerente_relac'] = 'bc' . $line['cd_mat_gerente_relac'];
                $line['cd_mat_gerente_local'] = 'bc' . $line['cd_mat_gerente_local'];
                $line['cd_mat_diretor'] = 'bc' . $line['cd_mat_diretor'];

                return  $line;
            }, $file);

            unset($files);

            // salva o resultado como json 
            Storage::disk('local')->put($capacityCharge['file_dir_json'], json_encode($lines));
        } catch (\Throwable $th) {
            Log::error(['Base capacity', $th]);
        }

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
