<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name');           
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // <GIP>
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
            $table->boolean('status');
            $table->string('status_real');
            // </GIP>
            $table->rememberToken();           
            $table->timestamps();     
            
            // Índices
            $table->index('name');
            $table->index('email');
            $table->index('email_verified_at');
            $table->index('password');
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
            $table->index('status');
            $table->index('status_real');
            

            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_users');
    }
}
