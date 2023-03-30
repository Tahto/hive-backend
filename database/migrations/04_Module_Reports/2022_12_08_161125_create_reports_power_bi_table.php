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
        Schema::create('reports_power_bi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->boolean('status');
            $table->by();
            $table->timestamps();

            $table->index('title');
            $table->index('url');
            $table->index('status');
        });

        //deleta chave sequencial atual
        $sequence = DB::getSequence();
        $sequence->drop('reports_power_bi_id_seq');

        //recria a trigger usando a chave reports_unique_id_seq 
        $trigger = DB::getTrigger();
        $trigger->drop('reports_power_bi_id_trg');
        $trigger->autoIncrement('reports_power_bi', 'id', 'reports_power_bi_id_trg', 'reports_unique_id_seq');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports_power_bi');
    }
};
