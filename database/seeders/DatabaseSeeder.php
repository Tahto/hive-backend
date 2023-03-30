<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modules\Wit\Planning\CapacityIndicator;
use App\Models\Sys\TimeRange;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*   
        TimeRange::create(['time' => '00:00:01', 'hour' => '00', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '00:30:01', 'hour' => '00', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '01:00:01', 'hour' => '01', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '01:30:01', 'hour' => '01', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '02:00:01', 'hour' => '02', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '02:30:01', 'hour' => '02', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '03:00:01', 'hour' => '03', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '03:30:01', 'hour' => '03', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '04:00:01', 'hour' => '04', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '04:30:01', 'hour' => '04', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '05:00:01', 'hour' => '05', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '05:30:01', 'hour' => '05', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '06:00:01', 'hour' => '06', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '06:30:01', 'hour' => '06', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '07:00:01', 'hour' => '07', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '07:30:01', 'hour' => '07', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '08:00:01', 'hour' => '08', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '08:30:01', 'hour' => '08', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '09:00:01', 'hour' => '09', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '09:30:01', 'hour' => '09', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '10:00:01', 'hour' => '10', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '10:30:01', 'hour' => '10', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '11:00:01', 'hour' => '11', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '11:30:01', 'hour' => '11', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '12:00:01', 'hour' => '12', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '12:30:01', 'hour' => '12', 'minute' => '30', 'active' => null]); 
        TimeRange::create(['time' => '13:00:01', 'hour' => '13', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '13:30:01', 'hour' => '13', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '14:00:01', 'hour' => '14', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '14:30:01', 'hour' => '14', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '15:00:01', 'hour' => '15', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '15:30:01', 'hour' => '15', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '16:00:01', 'hour' => '16', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '16:30:01', 'hour' => '16', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '17:00:01', 'hour' => '17', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '17:30:01', 'hour' => '17', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '18:00:01', 'hour' => '18', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '18:30:01', 'hour' => '18', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '19:00:01', 'hour' => '19', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '19:30:01', 'hour' => '19', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '20:00:01', 'hour' => '20', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '20:30:01', 'hour' => '20', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '21:00:01', 'hour' => '21', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '21:30:01', 'hour' => '21', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '22:00:01', 'hour' => '22', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '22:30:01', 'hour' => '22', 'minute' => '30', 'active' => null]);
        TimeRange::create(['time' => '23:00:01', 'hour' => '23', 'minute' => '00', 'active' => null]);
        TimeRange::create(['time' => '23:30:01', 'hour' => '23', 'minute' => '30', 'active' => null]);
       
 */
        CapacityIndicator::create(['type' => 0, 'display' => 'Dime Ativos', 'title' => 'nu_hc_dime', 'order' => '1', 'description' => 'HC dimensionado em Capacity']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Real Ativos', 'title' => 'nu_hc_real', 'order' => '1.1', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ, AUXILIAR) e STATUS_GIP igual(ATIVIDADE NORMAL ou AFAST. DOENCA MENOR 15 DIAS)']);
        CapacityIndicator::create(['type' => 2, 'display' => 'Dif Ativos', 'title' => 'nu_hc_dif', 'order' => '1.2', 'description' => 'Diferença entre "REAL ATIVOS" e "DIME ATIVOS"']);
        CapacityIndicator::create(['type' => 0, 'display' => 'Dime Ferias', 'title' => 'nu_ferias_dime', 'order' => '2', 'description' => 'HC em FÉRIAS dimensionado em Capacity']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Real Ferias', 'title' => 'nu_ferias_real', 'order' => '2.1', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ, AUXILIAR) e STATUS_GIP contém (FÉRIAS)']);
        CapacityIndicator::create(['type' => 2, 'display' => 'Dif Ferias', 'title' => 'nu_ferias_dif', 'order' => '2.2', 'description' => 'Diferença entre REAL_FERIAS e DIME_FERIAS']);
        CapacityIndicator::create(['type' => 0, 'display' => 'Dime Treino', 'title' => 'nu_treino_dime', 'order' => '3', 'description' => 'HC em TREINAMENTO dimensionado em Capacity']);
        CapacityIndicator::create(['type' => 0, 'display' => 'Dime Treino Inicial', 'title' => 'nu_tr_ini_dime', 'order' => '3.1', 'description' => 'HC em TREINAMENTO INICIAL dimensionado em Capacity']);
        CapacityIndicator::create(['type' => 0, 'display' => 'Dime Treino Migracao', 'title' => 'nu_tr_mig_dime', 'order' => '3.2', 'description' => 'HC em TREINAMENTO CAPACITY dimensionado em Capacity']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Real Treino', 'title' => 'nu_treino_real', 'order' => '3.3', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ) e STATUS_OP contém (ATIVO NO TR INICIAL ou ATIVO NO TR MIGRAÇÃO)']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Real Treino Inicial', 'title' => 'nu_tr_ini_real', 'order' => '3.4', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ) e STATUS_OP contém (ATIVO NO TR INICIAL)']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Real Treino Migracao', 'title' => 'nu_tr_mig_real', 'order' => '3.5', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ) e STATUS_OP contém (ATIVO NO TR MIGRAÇÃO)']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Real Treino Reciclagem', 'title' => 'nu_tr_reci_real', 'order' => '3.6', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ) e STATUS_OP contém (RECICLAGEM)']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Real Treino Retorno Afastamento', 'title' => 'nu_tr_ret_real', 'order' => '3.7', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ) e STATUS_OP contém (RETORNO)']);
        CapacityIndicator::create(['type' => 2, 'display' => 'Dif Treino', 'title' => 'nu_treino_dif', 'order' => '3.8', 'description' => 'Diferença entre REAL_TOTAL e DIME_TOTAL']);
        CapacityIndicator::create(['type' => 0, 'display' => 'HC Cliente', 'title' => 'nu_cli', 'order' => '4', 'description' => 'HC Cliente dimensionado em Capacity']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Ativos Total', 'title' => 'nu_ativos_total_real', 'order' => '4.1', 'description' => 'Total de Ativos (REAL_ATIVOS + REAL_FERIAS)']);
        CapacityIndicator::create(['type' => 0, 'display' => 'Dime Total', 'title' => 'nu_total_dime', 'order' => '4.2', 'description' => 'Total de HC dimensionado em Capacity (DIME_ATIVOS + DIME_FERIAS + DIME_TREINO)']);
        CapacityIndicator::create(['type' => 1, 'display' => 'Real Total', 'title' => 'nu_total_real', 'order' => '4.3', 'description' => 'Total de HC realizado no GIP (REAL_ATIVOS + REAL_FERIAS + REAL_TREINO)']);
        CapacityIndicator::create(['type' => 2, 'display' => 'Dif Total', 'title' => 'nu_total_dif', 'order' => '4.4', 'description' => 'Diferença entre REAL_TOTAL e DIME_TOTAL']);
        CapacityIndicator::create(['type' => 3, 'display' => 'Real Afastados', 'title' => 'nu_afastados_real', 'order' => '5', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ, AUXILIAR) e STATUS_OP contém (AFASTADO)']);
        CapacityIndicator::create(['type' => 3, 'display' => 'Real Desligados', 'title' => 'nu_desligados_real', 'order' => '5.1', 'description' => 'HC realizado no GIP com CARGO_RESUMIDO igual a (AGENTE ou JOVEM APRENDIZ) e STATUS_OP contém (DESLIGADO)']);
    }
}
