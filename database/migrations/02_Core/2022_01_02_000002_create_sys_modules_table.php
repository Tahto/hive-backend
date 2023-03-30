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
        Schema::create('sys_modules', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->unique();
            $table->string('to', 100)->unique();
            $table->string('icon');
            $table->string('description')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('status');
            $table->by();
            $table->timestamps();

            // Índices
            $table->index('title');
            $table->index('to');
            $table->index('icon');
            $table->index('description');
            $table->index('status');
        });

        //deleta chave sequencial atual
        $sequence = DB::getSequence();
        $sequence->drop('SYS_MODULES_ID_SEQ');

        //recria a trigger usando a chave sys_unique_source_id_seq 
        $trigger = DB::getTrigger();
        $trigger->drop('sys_modules_id_trg');
        $trigger->autoIncrement('sys_modules', 'id', 'sys_modules_id_trg', 'sys_unique_source_id_seq');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_modules');
    }
};
