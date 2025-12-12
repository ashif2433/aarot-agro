<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            // about-us, at-a-glance, mission, vision, inspiration, founder, advisor, team
            $table->string('section');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('image')->nullable(); // only image path
            $table->boolean('status')->default(1); // 1 = active, 0 = deactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abouts');
    }
}
