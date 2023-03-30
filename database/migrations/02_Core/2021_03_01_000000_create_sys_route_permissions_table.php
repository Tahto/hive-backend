<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysRoutePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_route_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('user_id', 20)->nullable(true);
            $table->string('sector_n1_id', 20)->nullable(true);
            $table->string('sector_n2_id', 20)->nullable(true);
            $table->string('manager_n1_id', 20)->nullable(true);
            $table->string('manager_n2_id', 20)->nullable(true);
            $table->string('manager_n3_id', 20)->nullable(true);
            $table->string('manager_n4_id', 20)->nullable(true);
            $table->string('manager_n5_id', 20)->nullable(true);
            $table->string('manager_n6_id', 20)->nullable(true);
            $table->string('hierarchical_level', 20)->nullable(true);
            $table->string('staff', 20)->nullable(true);
            $table->string('type', 20)->nullable(true);
            $table->boolean('allowed')->nullable(true);
            $table->by();
            $table->timestamps();

            // Índex
            $table->index('route_name');
            $table->index('user_id');
            $table->index('sector_n1_id');
            $table->index('sector_n2_id');
            $table->index('manager_n1_id');
            $table->index('manager_n2_id');
            $table->index('manager_n3_id');
            $table->index('manager_n4_id');
            $table->index('manager_n5_id');
            $table->index('manager_n6_id');
            $table->index('hierarchical_level');
            $table->index('staff');
            $table->index('type');
            $table->index('allowed');

            $table->unique([
                'route_name',
                'user_id',
                'sector_n1_id',
                'sector_n2_id',
                'manager_n1_id',
                'manager_n2_id',
                'manager_n3_id',
                'manager_n4_id',
                'manager_n5_id',
                'manager_n6_id',
                'hierarchical_level',
                'type',
                'allowed'
            ], 'un_sn1_sn2_hl');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_route_permissions');
    }
}
