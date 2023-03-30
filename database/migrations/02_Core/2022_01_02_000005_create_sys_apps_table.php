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
        Schema::create('sys_apps', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('route_api', 255);
            $table->unsignedBigInteger('menu_n2_id');
            $table->boolean('status');
            $table->by();
            $table->timestamps();

            // Índices
            $table->index('title');
            $table->index('route_api');
            $table->index('menu_n2_id');
            $table->index('status');
        });

        //deleta chave sequencial atual
        $sequence = DB::getSequence();
        $sequence->drop('sys_apps_id_seq');

        //recria a trigger usando a chave sys_unique_source_id_seq 
        $trigger = DB::getTrigger();
        $trigger->drop('sys_apps_id_trg');
        $trigger->autoIncrement('sys_apps', 'id', 'sys_apps_id_trg', 'sys_unique_source_id_seq');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_apps');
    }
};
