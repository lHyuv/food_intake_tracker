<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserissues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('user_issues')) return;
        Schema::create('user_issues', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            //
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('healthissue_id')->nullable()->constrained('health_issues')->onDelete('cascade')->onUpdate('cascade');  
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
        Schema::dropIfExists('user_issues');
    }
}
