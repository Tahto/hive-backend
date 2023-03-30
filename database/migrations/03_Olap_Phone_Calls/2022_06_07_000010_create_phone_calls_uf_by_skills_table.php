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
        Schema::connection('oracle-olap')->create('phone_calls_uf_by_skills', function (Blueprint $table) {
            $table->string('uf',5)->nullable();
            $table->string('skill_id',100)->nullable();
            $table->string('number',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('phone_calls_uf_by_skills');
    }
};
