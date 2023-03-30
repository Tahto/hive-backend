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
        Schema::connection('oracle-olap')->create('capacity_results', function (Blueprint $table) {
            $table->timestamp('ref');
            $table->timestamp('date');
            $table->unsignedBigInteger('sector_id');
            $table->unsignedBigInteger('indicator_id');
            $table->string('manager_n3_id', 20);
            $table->string('manager_n4_id', 20);
            $table->string('manager_n5_id', 20);
            $table->integer('type'); //0 dime, 1 Real, 3 Dif
            $table->integer('value')->nullable();
            $table->by();
            $table->timestamps();

            $table->index('ref');
            $table->index('sector_id');
            $table->index('manager_n3_id');
            $table->index('manager_n4_id');
            $table->index('manager_n5_id');
            $table->index('type');

            $table->unique([
                'ref',
                'date',
                'sector_id',
                'indicator_id',
            ], 'un_cr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('capacity_results');
    }
};
