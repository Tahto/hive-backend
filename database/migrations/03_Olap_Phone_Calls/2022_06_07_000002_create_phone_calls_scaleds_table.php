<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle-olap')->create('phone_calls_scaleds', function (Blueprint $table) {
            
            $table->date('date');
            $table->string('interval');
            $table->BigInteger('sector_n1_id');
            $table->float('received');
            $table->float('attended');
            $table->float('tma');
            $table->float('sec');
            $table->float('hc');
            $table->float('hc_pouse');
            $table->float('sla');
            $table->float('sla_pond');
            $table->float('weight_day');           
            
        });
        
         //Devido incompatibilidade com o Oracle, a aleração de tabela deve ser feita via DB::Class
        DB::statement('ALTER TABLE phone_calls_scaleds modify (received  FLOAT(126))');
        DB::statement('ALTER TABLE phone_calls_scaleds modify (attended  FLOAT(126))');
        DB::statement('ALTER TABLE phone_calls_scaleds modify (tma  FLOAT(126))');
        DB::statement('ALTER TABLE phone_calls_scaleds modify (sec  FLOAT(126))');
        DB::statement('ALTER TABLE phone_calls_scaleds modify (hc  FLOAT(126))');
        DB::statement('ALTER TABLE phone_calls_scaleds modify (hc_pouse  FLOAT(126))');
        DB::statement('ALTER TABLE phone_calls_scaleds modify (sla  FLOAT(126))');
        DB::statement('ALTER TABLE phone_calls_scaleds modify (sla_pond  FLOAT(126))');
        DB::statement('ALTER TABLE phone_calls_scaleds modify (weight_day  FLOAT(126))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('phone_calls_scaleds');
    }
};
