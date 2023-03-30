<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysGipSectorsN2Table extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_gip_sectors_n2', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->primary();
            $table->unsignedBigInteger('sector_n2_id', false);
           
            $table->string('name');
            $table->string('uf', 5);
            $table->timestamps();
            $table->softDeletes();

            // índices
          
            $table->index('sector_n2_id');
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
        Schema::dropIfExists('sys_gip_sectors_n2');
    }
}
