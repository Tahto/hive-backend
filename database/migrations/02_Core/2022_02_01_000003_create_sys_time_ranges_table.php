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
        Schema::create('sys_time_ranges', function (Blueprint $table) {
            $table->id();
            $table->string('time');
            $table->integer('hour');
            $table->integer('minute');
            $table->boolean('active')->nullable();
            $table->boolean('passed')->nullable();;
            $table->timestamps();

            // Índex
            $table->index('time');
            $table->index('minute');
            $table->index('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_time_ranges');
    }
};
