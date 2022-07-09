<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodproperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('food_properties')) return;
        Schema::create('food_properties', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            //
            $table->string('property');
            $table->foreignUuid('food_id')->constrained('foods')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('food_properties');
    }
}
