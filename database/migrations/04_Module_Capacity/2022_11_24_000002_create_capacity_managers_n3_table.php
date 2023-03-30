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
        Schema::connection('oracle-olap')->create('capacity_managers_n3', function (Blueprint $table) {
            
            // $table->id();
            $table->string('manager_n3_id', 20);
            $table->string('name',255)->nullable();
            $table->string('manager_n5_id', 20);
            $table->string('manager_n4_id', 20);
            $table->timestamp('ref');
            $table->by();
            $table->timestamps();

            $table->index('name');
            $table->index('manager_n5_id');
            $table->index('manager_n4_id');
            $table->index('ref');

            $table->unique([
                'manager_n3_id',
                'ref',
                'manager_n5_id',
                'manager_n4_id',
            ], 'un_cm_n3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('capacity_managers_n3');
    }
};
