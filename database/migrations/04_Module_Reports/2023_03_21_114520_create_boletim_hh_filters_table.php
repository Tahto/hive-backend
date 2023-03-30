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
        Schema::connection('oracle-olap')->create('boletim_hh_filters', function (Blueprint $table) {

            $table->string('user_id',20);
            $table->string('user_name');
            $table->string('position_summary');
            $table->integer('hierarchical_level');
            $table->unsignedBigInteger('sector_id');
            $table->string('sector_name');
            $table->timestamps();

            $table->primary(['user_id', 'sector_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('boletim_hh_filters');
    }
};
