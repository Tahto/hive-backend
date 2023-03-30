<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLogAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_log_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('route_uri');
            $table->string('route_name');
            $table->string('user_id',20);
            $table->longText('user');
            $table->string('ip');
            $table->string('hostname');
            $table->longText('request');
            $table->string('user_agent');
            $table->string('browser_name');
            $table->string('browser_family');
            $table->string('browser_version');
            $table->string('platform_name');
            $table->string('platform_family');
            $table->string('platform_version');
            $table->boolean('allowed')->nullable();
            $table->timestamps();

            // Índex
            $table->index('route_uri');
            $table->index('route_name');
            $table->index('user_id');          
            $table->index('ip');
            $table->index('hostname');          
            $table->index('user_agent');
            $table->index('browser_name');
            $table->index('browser_family');
            $table->index('browser_version');
            $table->index('platform_name');
            $table->index('platform_family');
            $table->index('platform_version');
            $table->index('allowed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_log_accesses');
    }
}
