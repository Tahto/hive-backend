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
        Schema::create('sys_status_default_booleans', function (Blueprint $table) {
            $table->id();
            $table->string('title',20);
            $table->string('alias_01',20);
            $table->string('alias_02',20);

            $table->index('title');
            $table->index('alias_01');
            $table->index('alias_02');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_status_default_booleans');
    }
};
