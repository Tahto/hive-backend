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
        Schema::create('sys_users_mobile_phones', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 20);
            $table->string('telegram_id', 20)->nullable();
            $table->unsignedBigInteger('phone_number');
            $table->by();
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['telegram_id']);
            $table->index(['phone_number']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_users_mobile_phones');
    }
};
