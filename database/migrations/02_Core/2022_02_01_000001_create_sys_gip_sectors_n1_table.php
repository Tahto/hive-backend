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
        Schema::create('sys_gip_sectors_n1', function (Blueprint $table) {
            $table->BigInteger('id')->primary();
            $table->string('name');
            $table->string('uf', 5);
            $table->timestamps();
            $table->softDeletes();

            // índices
            $table->index('name');
            $table->index('uf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_gip_sectors_n1');
    }
};
