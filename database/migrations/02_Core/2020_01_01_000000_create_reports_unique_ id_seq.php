<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReportsUniqueIdSeq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sequence = DB::getSequence();
        $sequence->create('reports_unique_id_seq');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sequence = DB::getSequence();
        $sequence->drop('reports_unique_id_seq');
    }
}
