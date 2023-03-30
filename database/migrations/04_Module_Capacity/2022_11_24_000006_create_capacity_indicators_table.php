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
        Schema::connection('oracle-olap')->create('capacity_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('display')->unique();
            $table->string('description');
            $table->integer('type'); //0 dime, 1 Real, 3 Dif
            $table->float('order');
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
        Schema::connection('oracle-olap')->dropIfExists('capacity_indicators');
    }
};
