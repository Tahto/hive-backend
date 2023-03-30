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
        Schema::create('sys_gip_daily', function (Blueprint $table) {
            $table->timestamp('ref');
            $table->timestamp('date');
            $table->string('id', 20);
            $table->string('name');           
            $table->string('uf');
            $table->string('position');
            $table->string('position_summary');
            $table->bigInteger('sector_n1_id');
            $table->bigInteger('sector_n2_id')->nullable(true);
            $table->string('manager_n1_id')->nullable(true);
            $table->string('manager_n2_id')->nullable(true);
            $table->string('manager_n3_id')->nullable(true);
            $table->string('manager_n4_id')->nullable(true);
            $table->string('manager_n5_id')->nullable(true);
            $table->string('manager_n6_id')->nullable(true);
            $table->bigInteger('hierarchical_level');
            $table->string('type')->nullable(true);
            $table->boolean('capacity');
            $table->boolean('vacation');
            $table->timestamp('admission')->nullable(true);
            $table->timestamp('rescind')->nullable(true);
            $table->boolean('status');
            $table->string('status_gip');
            $table->string('status_op');
            $table->string('training')->nullable(true);
            $table->timestamps();  

            // Índex
            $table->index('ref');
            $table->index('date');
            $table->index('id');
            $table->index('name');
            $table->index('uf');
            $table->index('position');
            $table->index('position_summary');
            $table->index('sector_n1_id');
            $table->index('sector_n2_id');
            $table->index('manager_n1_id');
            $table->index('manager_n2_id');
            $table->index('manager_n3_id');
            $table->index('manager_n4_id');
            $table->index('manager_n5_id');
            $table->index('manager_n6_id');
            $table->index('hierarchical_level');
            $table->index('type');
            $table->index('capacity');
            $table->index('vacation');
            $table->index('admission');
            $table->index('rescind');
            $table->index('status');
            $table->index('status_gip');
            $table->index('status_op');
            $table->index('training');
           
            $table->unique([
                'id',
                'ref', 
                'date',
            ], 'un_gip_daily');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_gip_daily');
    }
};
