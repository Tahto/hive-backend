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
        Schema::create('sys_calendar', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->unique();
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->integer('weekday');
            $table->boolean('business_day');
            $table->boolean('holiday_go')->nullable();
            $table->boolean('holiday_df')->nullable();
            $table->boolean('holiday_ms')->nullable();
            $table->boolean('holiday_pr')->nullable();
            $table->boolean('holiday_rj')->nullable();
            $table->boolean('holiday_se')->nullable();
            $table->boolean('holiday_br')->nullable();
            $table->boolean('active');
            $table->boolean('passed');
            $table->timestamps();


            // Índex
            $table->index('year');
            $table->index('month');
            $table->index('day');
            $table->index('date');
            $table->index('weekday');
            $table->index('business_day');
            $table->index('active');
            $table->index('passed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_calendar');
    }
};
