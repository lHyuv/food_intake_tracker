<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('roles')) return;
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            //
            $table->string('name')->default('Client');
            //
            $table->string('status')->default('Active');
            $table->timestamps();
            $table->sofDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
