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
            $table->string('physical_activity');
            $table->string('age');
            $table->string('weight');
            $table->string('gender');
            $table->foreignUuid('healthissue_id')->constrained('healthissues')->onDelete('cascade')->onUpdate('cascade');  
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
