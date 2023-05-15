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
        Schema::connection('oracle-olap')->create('rv_terms_charges', function (Blueprint $table) {
            $table->id();
            $table->timestamp('ref');
            $table->integer('files');
            $table->integer('filesfails');
            $table->text('info')->nullable();
            $table->boolean('status');
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
        Schema::connection('oracle-olap')->dropIfExists('rv_terms_charges');
    }
};
