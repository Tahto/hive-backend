<?php

namespace App\Console\Commands\Sys;

use Illuminate\Console\Command;
use App\Models\Sys\GipSectorN2;
use App\Models\SourceGipConsQuadroUnificado;

class SectorsN2Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sectorsn2:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a lista de setores N2';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $dados =  SourceGipConsQuadroUnificado::orderBy('id', 'asc')
                ->whereNotNull('cod_sub_setor')
                ->where('cod_sub_setor', '<>', 0)
                ->get(['cod_sub_setor as id', 'cod_dpto as sector_n2_id', 'sub_setor as name', 'uf'])
                ->unique('id')
                ->toArray();

            foreach ($dados as $value) {
                $obj = GipSectorN2::find($value['id']) ? GipSectorN2::find($value['id']) : new GipSectorN2($value);

                $obj['name'] = ucfirstException($value['name']);
                $obj['uf'] = $value['uf'];
                $obj['sector_n2_id'] = $value['sector_n2_id'];

                $obj->save();
            }
        } catch (\Throwable $th) {

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
