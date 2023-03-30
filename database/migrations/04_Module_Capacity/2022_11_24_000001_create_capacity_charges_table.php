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
        Schema::connection('oracle-olap')->create('capacity_charges', function (Blueprint $table) {
            $table->id();
            $table->timestamp('ref');
            $table->string('file_dir');
            $table->integer('status',1);
            $table->by();
            $table->timestamps();

            $table->index('ref');
            $table->index('file_dir');
            $table->index('status');
            $table->index('updated_by');
            $table->index('created_by');
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('capacity_charges');
    }
};
