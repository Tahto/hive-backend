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
        Schema::create('reports_power_bi_owners', function (Blueprint $table) {
            $table->id();
            $table->string('owner_id', 20);
            $table->unsignedBigInteger('report_id');
            $table->boolean('status')->default('1');
            $table->by();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports_power_bi_owners');
    }
};
