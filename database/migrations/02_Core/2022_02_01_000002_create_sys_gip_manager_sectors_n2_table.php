<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysGipManagerSectorsN2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_gip_manager_sectors_n2', function (Blueprint $table) {
         
            $table->unsignedBigInteger('sector_n2_id');
            $table->string('manager_n1_id', 20);
            $table->string('manager_n2_id', 20);
            $table->string('manager_n3_id', 20);
            $table->string('manager_n4_id', 20);
            $table->string('manager_n5_id', 20);
            $table->string('manager_n6_id', 20);            
            $table->timestamps();
            
            $table->index('sector_n2_id');
            $table->index('manager_n1_id');
            $table->index('manager_n2_id');
            $table->index('manager_n3_id');
            $table->index('manager_n4_id');
            $table->index('manager_n5_id');
            $table->index('manager_n6_id');

            $table->unique([
                'sector_n2_id',
                'manager_n1_id',
                'manager_n2_id',
                'manager_n3_id',
                'manager_n4_id',
                'manager_n5_id',
                'manager_n6_id',
            ], 'un_mng_sc_n2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
     
        Schema::dropIfExists('sys_gip_manager_sectors_n2');
    }
}
