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
        Schema::connection('oracle-olap')->create('capacity_managers_sectors', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('sector_id');
            $table->string('name');
            $table->string('uf',4);
            $table->string('manager_n5_id', 20);
            $table->string('manager_n4_id', 20);
            $table->string('manager_n3_id', 20);
            $table->timestamp('ref');
            $table->by();
            $table->timestamps();

            $table->index('ref');
            $table->index('sector_id');
            $table->index('name');
            $table->index('uf');
            $table->index('manager_n5_id');
            $table->index('manager_n4_id');
            $table->index('manager_n3_id');

            $table->unique([
                'ref',
                'sector_id',
                'name',
                'uf',
                'manager_n5_id',
                'manager_n4_id',
                'manager_n3_id',
            ], 'un_cms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('capacity_managers_sectors');
    }
};
