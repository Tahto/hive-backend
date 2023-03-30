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
        Schema::connection('oracle-olap')->create('phone_scaleds_waits', function (Blueprint $table) {
            $table->date('ref');
            $table->BigInteger('sector_n1_id', false);
            $table->string('manager', false);
            $table->integer('tme');
            $table->timestamp('update_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle-olap')->dropIfExists('phone_scaleds_waits');

    }
};
