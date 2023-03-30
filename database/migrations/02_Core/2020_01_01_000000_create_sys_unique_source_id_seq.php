<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSysUniqueSourceIdSeq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sequence = DB::getSequence();
        $sequence->create('sys_unique_source_id_seq');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sequence = DB::getSequence();
        $sequence->drop('sys_unique_source_id_seq');
    }
}
