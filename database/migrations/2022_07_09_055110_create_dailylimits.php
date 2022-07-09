<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailylimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('dailylimits')) return;
        Schema::create('dailylimits', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            //
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('dailylimit_id')->constrained('dailylimits')->onDelete('cascade')->onUpdate('cascade');
            $table->float('value');
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
        Schema::dropIfExists('dailylimits');
    }
}
