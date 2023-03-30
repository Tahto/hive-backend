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
        Schema::connection('oracle-olap')->create('phone_calls_by_sectors_n1_rt', function (Blueprint $table) {
            $table->string("sector_n1_id");
            $table->integer("allcalls");
            $table->integer("abandoned");
            $table->integer("abandonedtime");
            $table->integer("diverted");
            $table->integer("divertedtime");
            $table->integer("callduration");
            $table->integer("inboundtime");
            $table->integer("outboundtime");
            $table->integer("consulttime");
            $table->integer("diverted10S");
            $table->integer("diverted20S");
            $table->integer("diverted30S");
            $table->integer("diverted40S");
            $table->integer("diverted60S");
            $table->integer("diverted180s");
            $table->integer("abandon10S");
            $table->integer("abandon20S");
            $table->integer("abandon30S");
            $table->integer("abandon40S");
            $table->integer("abandon60S");
            $table->integer("abandon180s");
            $table->integer("callavg");
            $table->integer("waitavg");
            $table->integer("loggedtime");
            $table->integer("pausedtime");
            $table->timestamp("update_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('phone_calls_by_sectors_n1_rt');
    }
};
