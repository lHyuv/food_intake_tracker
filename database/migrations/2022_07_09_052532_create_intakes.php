<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntakes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('intakes')) return; 
        Schema::create('intakes', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            //
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('food_id')->nullable()->constrained('foods')->onDelete('cascade')->onUpdate('cascade'); 
            $table->float('serving');
            $table->string('ext_food_id')->nullable();
            $table->text('ext_food_name')->nullable();
            $table->string('type');
            //
            $table->string('ext_vitamin_a')->nullable();
            $table->string('ext_vitamin_c')->nullable();
            $table->string('ext_vitamin_d')->nullable();
            $table->string('ext_vitamin_e')->nullable();
            $table->string('ext_fat')->nullable();
            $table->string('ext_protein')->nullable();
            $table->string('ext_salt')->nullable();
            $table->string('ext_sugar')->nullable();
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
        Schema::dropIfExists('intakes');
    }
}
