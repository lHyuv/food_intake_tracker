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
        if(Schema::hasTable('users')) return; 
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            //
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            //
            $table->string('physical_activity')->nullable();
            $table->integer('age')->nullable();
            $table->float('weight')->nullable();
            $table->string('gender')->nullable();
            $table->foreignUuid('role_id')->constrained('roles')->onDelete('cascade')->onUpdate('cascade');  
            //
            $table->string('status')->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
