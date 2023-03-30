<?php

namespace App\Console\Commands\Sys;

use Illuminate\Console\Command;
use App\Models\Sys\GipSectorN1;
use App\Models\SourceGipConsQuadroUnificado;


class SectorsN1Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sectorsn1:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a lista de setores N1';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            $dados =  SourceGipConsQuadroUnificado::whereNotNull('cod_dpto')
                ->get(['cod_dpto as id', 'dpto as name', 'uf'])
                ->unique('id')
                ->toArray();

            // return $dados;
            foreach ($dados as $value) {
                $obj = GipSectorN1::find($value['id']) ? GipSectorN1::find($value['id']) : new GipSectorN1($value);

                $obj['name'] = mb_convert_case($value['name'], MB_CASE_TITLE, 'UTF-8');
                $obj['uf'] = $value['uf'];

                $obj->save();
            }
        } catch (\Throwable $th) {

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
