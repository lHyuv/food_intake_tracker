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
        if(Schema::hasTable('daily_limits')) return;
        Schema::create('daily_limits', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            //
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->float('vitamin_a')->nullable();
            $table->float('vitamin_c')->nullable();
            $table->float('vitamin_d')->nullable();
            $table->float('vitamin_e')->nullable();
            $table->float('salt')->nullable();
            $table->float('sugar')->nullable();
            $table->float('fat')->nullable();
            $table->float('protein')->nullable();
            $table->float('calorie')->nullable();
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
        Schema::dropIfExists('daily_limits');
    }
}
