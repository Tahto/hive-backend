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
        Schema::connection('oracle-olap')->create('rv_terms', function (Blueprint $table) {
            $table->id();
            $table->date('ref');
            $table->integer('sector_n1_id');
            $table->integer('sector_n2_id');
            $table->integer('version');
            $table->string('hierarchical_level',5);
            $table->string('maturity',10);
            $table->string('campaign');
            $table->string('approver')->nullable();
            $table->string('approver_ip')->nullable();
            $table->string('approver_host')->nullable();
            $table->string('approver_date')->nullable();
            $table->unsignedBigInteger('charge_id');
            $table->string('status');
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
        Schema::connection('oracle-olap')->dropIfExists('rv_terms');
    }
};
