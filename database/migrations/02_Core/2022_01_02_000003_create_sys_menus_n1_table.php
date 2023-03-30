<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSysMenusN1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_menus_n1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->string('title');
            $table->string('icon');
            $table->string('to');
            $table->string('route_api', 255);
            $table->integer('order')->nullable();
            $table->boolean('status');
            $table->by();
            $table->timestamps();

            // Índices
            $table->index('module_id');
            $table->index('title');
            $table->index('icon');
            $table->index('to');
            $table->index('route_api');
            $table->index('status');
        });

        //deleta chave sequencial atual
        $sequence = DB::getSequence();
        $sequence->drop('SYS_MENUS_N1_ID_SEQ');

        //recria a trigger usando a chave sys_unique_source_id_seq 
        $trigger = DB::getTrigger();
        $trigger->drop('sys_menus_n1_id_trg');
        $trigger->autoIncrement('sys_menus_n1', 'id', 'sys_menus_n1_id_trg', 'sys_unique_source_id_seq');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_menus_n1');
    }
}
