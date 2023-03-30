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
        Schema::connection('oracle-olap')->create('capacity_managers_n5', function (Blueprint $table) {
           
            // $table->id();
            $table->string('manager_n5_id', 20);
            $table->string('name',255)->nullable();
            $table->timestamp('ref');
            $table->by();
            $table->timestamps();

            $table->index('name');
            $table->index('ref');

            $table->unique([
                'manager_n5_id',
                'ref',
            ], 'un_cm_n5');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('capacity_managers_n5');
    }
};
