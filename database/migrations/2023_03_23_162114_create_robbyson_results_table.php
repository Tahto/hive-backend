<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle-olap')->create('robbyson_results', function (Blueprint $table) {
            
            $table->integer('cd_ano');
            $table->integer('cd_mes');
            $table->integer('cd_matricula');
            $table->integer('cd_setor');
            $table->integer('cd_indicador');
            $table->float('cd_meta');
            $table->float('cd_resultado');
            $table->float('cd_fator_0');
            $table->float('cd_fator_1');
            $table->float('cd_fator_2');
            $table->integer('cd_dt_ref');
            $table->integer('sk_ip');
            $table->integer('cd_inserido_por');
            $table->integer('cd_dt_registro');


            $table->primary(['cd_matricula', 'cd_indicador', 'cd_dt_ref']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('robbyson_results');
    }
};
