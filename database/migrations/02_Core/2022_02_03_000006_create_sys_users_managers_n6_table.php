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
        Schema::create('sys_users_managers_n6', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name',255)->nullable();
            $table->bigInteger('hierarchical_level');
            $table->boolean('status');
            $table->timestamps();

            $table->index('name');
            $table->index('hierarchical_level');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_users_managers_n6');
    }
};
